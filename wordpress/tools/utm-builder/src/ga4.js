/*
 * GA4 default channel group predictor.
 * Mirrors Google's published rules (Analytics Help: "[GA4] Default channel group"),
 * evaluated top to bottom, first match wins. The site lists are a practical subset
 * of Google's source categories, so treat the result as a close prediction.
 * Works in the browser (window.UTMGA4) and in Node (module.exports) for the build.
 */
(function (root) {
  var SEARCH = ['google', 'bing', 'yahoo', 'duckduckgo', 'baidu', 'yandex', 'ecosia', 'naver', 'ask', 'aol',
    'startpage', 'qwant', 'seznam', 'daum', 'sogou', 'so.com', 'msn', 'google.com', 'bing.com', 'yahoo.com',
    'duckduckgo.com', 'search.yahoo.com', 'search.brave.com', 'yandex.ru', 'baidu.com'];
  var SOCIAL = ['facebook', 'fb', 'facebook.com', 'm.facebook.com', 'l.facebook.com', 'lm.facebook.com',
    'instagram', 'ig', 'instagram.com', 'l.instagram.com', 'linkedin', 'linkedin.com', 'lnkd.in',
    'twitter', 'twitter.com', 't.co', 'tiktok', 'tiktok.com', 'pinterest', 'pinterest.com', 'snapchat',
    'snapchat.com', 'reddit', 'reddit.com', 'quora', 'quora.com', 'threads', 'threads.net', 'whatsapp',
    'whatsapp.com', 'messenger', 'tumblr', 'vk', 'vk.com', 'weibo', 'line', 'discord', 'telegram'];
  var VIDEO = ['youtube', 'youtube.com', 'm.youtube.com', 'youtu.be', 'vimeo', 'vimeo.com', 'dailymotion',
    'dailymotion.com', 'twitch', 'twitch.tv', 'wistia'];
  var SHOPPING = ['amazon', 'amazon.com', 'amazon.ae', 'amazon.sa', 'ebay', 'ebay.com', 'etsy', 'etsy.com',
    'walmart', 'walmart.com', 'shopify', 'shopify.com', 'igshopping', 'mercadolibre', 'alibaba', 'aliexpress'];

  var PAID = /^(.*cp.*|ppc|retargeting|paid.*)$/;
  var SHOP_CAMPAIGN = /^(.*(([^a-df-z]|^)shop|shopping).*)$/;
  var EMAIL = ['email', 'e-mail', 'e_mail', 'e mail'];
  var SOCIAL_MEDIUMS = ['social', 'social-network', 'social-media', 'sm', 'social network', 'social media'];
  var DISPLAY_MEDIUMS = ['display', 'banner', 'expandable', 'interstitial', 'cpm'];

  function has(list, v) { return list.indexOf(v) !== -1; }

  function classify(sourceIn, mediumIn, campaignIn) {
    var s = String(sourceIn || '').trim().toLowerCase();
    var m = String(mediumIn || '').trim().toLowerCase();
    var c = String(campaignIn || '').trim().toLowerCase();
    var paid = PAID.test(m);
    var shopCamp = SHOP_CAMPAIGN.test(c);
    var q = function (v) { return '“' + v + '”'; };

    if (!s && !m) return { channel: 'Direct', reason: 'No source or medium, so GA4 treats the visit as direct.' };
    if (s === '(direct)' && (m === '(none)' || m === '(not set)' || !m)) return { channel: 'Direct', reason: 'Source is (direct).' };
    if (c.indexOf('cross-network') !== -1) return { channel: 'Cross-network', reason: 'The campaign name contains ' + q('cross-network') + '.' };
    if ((has(SHOPPING, s) || shopCamp) && paid) return { channel: 'Paid Shopping', reason: (has(SHOPPING, s) ? q(s) + ' is a shopping site' : 'the campaign name contains ' + q('shop') + ' or ' + q('shopping')) + ' and ' + q(m) + ' is a paid medium.' };
    if (has(SEARCH, s) && paid) return { channel: 'Paid Search', reason: q(s) + ' is a search engine and ' + q(m) + ' is a paid medium.' };
    if (has(SOCIAL, s) && paid) return { channel: 'Paid Social', reason: q(s) + ' is a social site and ' + q(m) + ' is a paid medium.' };
    if (has(VIDEO, s) && paid) return { channel: 'Paid Video', reason: q(s) + ' is a video site and ' + q(m) + ' is a paid medium.' };
    if (has(DISPLAY_MEDIUMS, m)) return { channel: 'Display', reason: q(m) + ' is one of GA4’s display mediums.' };
    if (paid) return { channel: 'Paid Other', reason: q(m) + ' is a paid medium, but GA4 doesn’t recognise ' + q(s || '(empty)') + ' as a search, social, video or shopping site.' };
    if (has(SHOPPING, s) || shopCamp) return { channel: 'Organic Shopping', reason: has(SHOPPING, s) ? q(s) + ' is a shopping site and the medium isn’t paid.' : 'The campaign name contains ' + q('shop') + ' and the medium isn’t paid.' };
    if (has(SOCIAL, s) || has(SOCIAL_MEDIUMS, m)) return { channel: 'Organic Social', reason: has(SOCIAL, s) ? q(s) + ' is a social site and the medium isn’t paid.' : q(m) + ' is one of GA4’s social mediums.' };
    if (has(VIDEO, s) || /video/.test(m)) return { channel: 'Organic Video', reason: has(VIDEO, s) ? q(s) + ' is a video site and the medium isn’t paid.' : 'The medium contains ' + q('video') + '.' };
    if (has(SEARCH, s) || m === 'organic') return { channel: 'Organic Search', reason: m === 'organic' ? 'The medium is ' + q('organic') + '.' : q(s) + ' is a search engine and the medium isn’t paid.' };
    if (m === 'referral' || m === 'app' || m === 'link') return { channel: 'Referral', reason: q(m) + ' is a referral medium.' };
    if (has(EMAIL, s) || has(EMAIL, m)) return { channel: 'Email', reason: (has(EMAIL, m) ? 'The medium' : 'The source') + ' is ' + q(has(EMAIL, m) ? m : s) + '.' };
    if (m === 'affiliate') return { channel: 'Affiliates', reason: 'The medium is ' + q('affiliate') + '.' };
    if (m === 'audio') return { channel: 'Audio', reason: 'The medium is ' + q('audio') + '.' };
    if (s === 'sms' || m === 'sms') return { channel: 'SMS', reason: (m === 'sms' ? 'The medium' : 'The source') + ' is ' + q('sms') + '.' };
    if (/push$/.test(m) || /mobile|notification/.test(m) || s === 'firebase') return { channel: 'Mobile Push Notifications', reason: 'The medium ends in ' + q('push') + ' or mentions mobile/notification.' };
    return { channel: 'Unassigned', reason: q(m || '(empty)') + ' doesn’t match any GA4 default rule, and ' + q(s || '(empty)') + ' isn’t a recognised site.' };
  }

  var api = { classify: classify, lists: { SEARCH: SEARCH, SOCIAL: SOCIAL, VIDEO: VIDEO, SHOPPING: SHOPPING } };
  if (typeof module !== 'undefined' && module.exports) module.exports = api;
  else root.UTMGA4 = api;
})(typeof window !== 'undefined' ? window : this);
