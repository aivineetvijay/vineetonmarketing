"""Builds content/essays/on-page-seo-ai-search.json from the approved review doc (20 Nov 2026).
Usage: python3 on-page-seo-ai-search.py <out.json>"""
import json, sys

def a(text, href):
    return '<a href="%s">%s</a>' % (href, text)

SITE = 'https://vineetonmarketing.com'
G_GUIDE = 'https://developers.google.com/search/docs/fundamentals/ai-optimization-guide'
SULLIVAN = 'https://www.seroundtable.com/google-content-bite-sized-chunks-40728.html'
GEO = 'https://arxiv.org/abs/2311.09735'
INDIG = 'https://www.searchenginejournal.com/the-science-of-how-ai-pays-attention/561306/'
RESONEO = 'https://think.resoneo.com/chatgpt-retrieval/'
OPENAI_BOTS = 'https://platform.openai.com/docs/bots'
PPLX_BOTS = 'https://docs.perplexity.ai/guides/bots'
AHREFS_FANOUT = 'https://ahrefs.com/blog/query-fan-out-chatgpt/'

toc = [
    ['What did Google actually say about AI search?', 'google-guide'],
    ["I scored 12 common AI tactics. Here's the table.", 'scorecard'],
    ['Why the "keep" items work: they were always good SEO', 'keep'],
    ['Three things you can stop doing for Google', 'skip'],
    ['Where ChatGPT and Perplexity really are different', 'other-engines'],
    ['The Rename Test: four checks before you add an AI tactic', 'rename-test'],
    ['Frequently asked questions', 'faq'],
]

b = [
 ['p', "<strong>In May, I was halfway through rebuilding a blog post for AI search. I'd split it into small blocks and added extra schema types, because every AI checklist said so. Then Google published its own guide to AI search, and it named both as things I didn't need to do. So here's the short answer: most on-page SEO for AI search is ordinary on-page SEO with a new name. A few popular tactics do nothing for Google, and only a short list really changes for ChatGPT and Perplexity.</strong>"],
 ['p', "That's the short answer. Here's what Google actually said, my scorecard of 12 common \"AI\" tactics, and a simple test you can run before you add anything with AI in its name."],
 ['box', 'Key takeaways', 'ul', [
   "Google's May 2026 guide says AI Overviews and AI Mode need no special optimisation. To Google, optimising for AI search is still SEO.",
   "Google names llms.txt, content chunking, AI-specific rewriting and special schema as tactics you don't need for its AI features.",
   "What helps, such as a direct answer under each heading and named sources, was good on-page SEO long before AI search.",
   "ChatGPT leans on the top of the page: one study found 44.2% of its citations came from the first 30% of a page's content."]],
 ['toc', 'In this article', toc],

 ['h2', toc[0][0], toc[0][1]],
 ['p', "On 15 May 2026, Google published " + a('Optimizing your website for generative AI features on Google Search', G_GUIDE) + ". Its main message fits in two words: to Google, optimising for generative AI search is \"still SEO\". A section called \"Mythbusting generative AI search\" then lists what you don't need to do:"],
 ['ul', [
   "create llms.txt files or other special markup",
   "\"chunk\" your content into small pieces",
   "rewrite content in a special way for AI systems",
   "chase inauthentic mentions of your brand",
   "overfocus on structured data"]],
 ['p', "None of this was new. In January 2026, on Google's Search Off the Record podcast, Danny Sullivan said he'd checked the \"bite-sized chunks\" advice with Google's engineers. " + a('His answer', SULLIVAN) + ": \"We don't want you to do that.\""],
 ['p', "<strong>When the platform tells you what it ignores, believe it before you believe a checklist.</strong>"],

 ['h2', toc[1][0], toc[1][1]],
 ['p', "I took the tactics that keep coming up in the top-ranking guides on on-page SEO for AI search, and checked each against Google's guide, the public studies and real pages."],
 ['table', ['Tactic', 'Verdict', 'Why', 'Source'], [
   ['<strong>A direct answer under each heading</strong>', 'Keep', 'AI answers quote passages; readers skim', "Google's guide; my Reem Hospital pages"],
   ['<strong>Question-style H2s</strong>', 'Keep', 'They match how people search and ask', 'People Also Ask results'],
   ['<strong>A real FAQ block on the page</strong>', 'Keep', 'Answers follow-up questions plainly', 'My Reem Hospital pages'],
   ['<strong>FAQPage schema</strong>', 'Depends', 'No Google FAQ rich results since 7 May 2026; other engines may still use it', "Google's FAQPage documentation"],
   ['<strong>A visible author with a short bio</strong>', 'Keep', 'Shows who stands behind the page', 'My Reem Hospital pages'],
   ['<strong>An honest "last updated" date</strong>', 'Keep', 'Freshness matters; a fake date helps nobody', 'My Reem Hospital pages'],
   ['<strong>Statistics with named, dated sources</strong>', 'Keep', 'A checkable claim is a quotable claim', 'Princeton GEO study, 2024'],
   ['<strong>Allowing AI crawlers in robots.txt</strong>', 'Depends', 'ChatGPT and Perplexity use their own crawlers', 'OpenAI and Perplexity documentation'],
   ['<strong>Chunking content into small blocks</strong>', 'Skip', "Google says you don't need it", "Google's guide; Danny Sullivan, Jan 2026"],
   ['<strong>An llms.txt file</strong>', 'Skip for Google', 'Google ignores it; other tools may read it', "Google's guide"],
   ['<strong>Special "AI schema"</strong>', 'Skip', 'There is no special Schema.org markup for AI features', "Google's guide"],
   ['<strong>A separate "AI version" of the page</strong>', 'Skip', "Google's AI understands synonyms and meaning", "Google's guide"]]],
 ['cite', "Source: author's framework, using Google's May 2026 AI optimisation guide and the studies linked in this post."],
 ['p', "<strong>Six of the twelve are " + a('on-page SEO', SITE + '/on-page-seo/') + " with a new name. Four do nothing for Google. Only two depend on the engine.</strong>"],

 ['h2', toc[2][0], toc[2][1]],
 ['p', "Between 2024 and 2025, six pages on Reem Hospital's website were quoted in Google's AI Overviews or a featured snippet. One of them sat next to Cleveland Clinic for the one-word query \"pulmonologist\". The site's Moz domain authority was 17."],
 ['p', "None of them used an \"AI tactic\". Looking back, they shared four plain habits:"],
 ['ol', [
   "<strong>The answer sat right under the heading.</strong> Google lifted those sentences almost word for word.",
   "<strong>Real questions got real answers.</strong> The FAQ blocks used patients' own words.",
   "<strong>You could see who wrote it, and when.</strong> Author and date were on the page.",
   "<strong>Claims carried sources.</strong> A number always said where it came from."]],
 ['p', "I wrote up the full story in " + a('How to rank in AI Overviews: what I learned getting cited', SITE + '/rank-in-ai-overviews/') + "."],
 ['p', "The research agrees. In the study that named generative engine optimisation (GEO), " + a('researchers at Princeton and IIT Delhi', GEO) + " found that adding statistics, quotations and sources were among the most effective changes, lifting visibility in AI answers by up to 40%."],
 ['p', "<strong>The reader and the machine want the same thing: the answer, early, from someone they can check.</strong>"],

 ['h2', toc[3][0], toc[3][1]],
 ['p', "I stopped doing two of these myself after May."],
 ['ol', [
   "<strong>Chunking content.</strong> That blog post I was rebuilding? I put it back together. Google says there's no requirement to break content into tiny pieces. Short paragraphs for readers are good writing. Chopping a page up for a machine isn't.",
   "<strong>Extra schema \"for AI\".</strong> Google says there is no special Schema.org markup for AI features. Keep the schema that honestly describes your page; " + a("Schema markup is your website's resume", SITE + '/schema-markup-ai-visibility/') + " explains which kinds matter.",
   "<strong>llms.txt, for Google.</strong> I'll be upfront, because I build llms.txt generators: this file is not a Google tactic. Where it may help is outside Google Search. Google's own Lighthouse tool has an experimental audit for AI agents that checks for it, and some AI tools may read it. It takes ten minutes with my free " + a('llms.txt generator', SITE + '/ai-tools/llms-txt-generator/') + ", so I still add one. Just don't pay anyone who sells it as a fix for AI Overviews."]],
 ['quote', "If a tactic only makes sense to a machine, Google has probably already told you to skip it.", ''],

 ['h2', toc[4][0], toc[4][1]],
 ['p', "Google's guide covers Google. ChatGPT and Perplexity run their own retrieval, and three findings show what that means on the page."],
 ['ul', [
   "<strong>The top of the page does the heavy lifting.</strong> In February 2026, Kevin Indig " + a('analysed 18,012 verified ChatGPT citations', INDIG) + ". He found 44.2% came from the first 30% of a page's content.",
   "<strong>Your H1 travels with you.</strong> In July 2026, the SEO consultancy Resoneo " + a('captured 1,249 ChatGPT answers', RESONEO) + ". ChatGPT's own index kept roughly 200 characters per page. On cited pages that had an H1, the H1 was in that stored snippet 83.6% of the time.",
   "<strong>They use their own crawlers.</strong> ChatGPT search relies on " + a('OAI-SearchBot', OPENAI_BOTS) + ", and Perplexity on " + a('PerplexityBot', PPLX_BOTS) + ". If your robots.txt file or your CDN blocks them, no amount of on-page work will help."]],
 ['p', "So for these engines, your H1 and opening paragraphs carry the most weight. That's not new either. Journalists have put the key facts first for generations. If you run a local business, it's also worth claiming your " + a('ChatGPT business profile', SITE + '/businesses-in-chatgpt/') + "."],
 ['p', "<strong>Write a clear H1 and put the answer at the top. That one habit serves Google, ChatGPT and your reader at once.</strong>"],

 ['h2', toc[5][0], toc[5][1]],
 ['p', "Every few weeks, someone shows me a new AI tactic. Usually it's an old one with a new name. So I run four checks first."],
 ['callout', 'Framework', 'The Rename Test', 'ol', [
   "<strong>Reader:</strong> Would it help a person reading the page? If not, stop.",
   "<strong>Skip list:</strong> Is it on Google's \"what you don't need to do\" list? Then it won't help in Google.",
   "<strong>Engine:</strong> Which engine is it for: Google, ChatGPT, Perplexity or Microsoft Copilot? \"AI\" is not an engine.",
   "<strong>Measure:</strong> How will you know it worked? If you can't measure it, you can't defend the budget."]],
 ['p', "<strong>Where this breaks.</strong> The studies here show patterns, not cause and effect, and the engines change fast. Ahrefs found that about 1 in 5 ChatGPT answers cited Reddit in March 2026, but by late September it was " + a('about 1 in 43', AHREFS_FANOUT) + ". So treat my scorecard as a starting point, and recheck it every few months."],
 ['note', 'What to do on Monday', 'ul', [
   "Check your top five pages: does the answer sit in the first two sentences under each heading?",
   "Remove chunked blocks or \"AI versions\" that repeat the page.",
   "Make sure robots.txt and your CDN allow Googlebot, OAI-SearchBot and PerplexityBot.",
   "Add a visible author and an honest \"last updated\" date."]],
 ['tip', 'Bonus Tip: check Search Console before you buy a GEO tool', "Google counts clicks from AI Overviews and AI Mode in Search Console's Performance report, under the Web search type. So look at which pages already earn those clicks before you pay for an AI visibility tool. My post on " + a('AI visibility scores', SITE + '/ai-visibility-score/') + " explains what's actually worth measuring."],

 ['h2', toc[6][0], toc[6][1]],
 ['h3s', 'What is on-page SEO for AI search?'],
 ['p', "On-page SEO for AI search is the work you do on a page so AI tools like Google's AI Overviews, AI Mode and ChatGPT can find, understand and quote it. In practice it is mostly standard on-page SEO: a clear title and H1, a direct answer under each heading, named sources and a visible author."],
 ['h3s', 'Do I need an llms.txt file for Google AI Overviews?'],
 ['p', "No. Google's May 2026 guide says you don't need llms.txt or other special files to appear in its generative AI features. Some other AI tools and agents may still read the file, so it can be worth ten minutes to add one. Just don't treat it as an AI Overviews tactic."],
 ['h3s', 'Should I chunk my content for AI search?'],
 ['p', "Not for Google. Google's guide says there is no requirement to break content into tiny pieces, and Danny Sullivan said in January 2026 that Google doesn't want you to. Write short, clear paragraphs for your readers. That helps every engine without creating a second version of the page."],
 ['h3s', 'Is FAQ schema still worth adding?'],
 ['p', "It depends. Google stopped showing FAQ rich results on 7 May 2026, so FAQPage markup no longer earns that display in Google. The markup is still valid, and other engines may use it. A real FAQ block on the page, answering the questions people ask, is still worth having."],
 ['h3s', 'Is optimising for ChatGPT different from optimising for Google?'],
 ['p', "Slightly. Google says its AI features need no special optimisation. ChatGPT uses its own index and its own crawler, OAI-SearchBot, and studies show it cites the top of a page most often. So the main extra steps are allowing its crawler and putting a clear H1 and answer at the top."],
 ['cta', "Have you tried an AI tactic that made a difference you could actually measure?", "If you try the Rename Test, or if it doesn't work the way I described, write to me. I'd genuinely love to hear how it goes.", 'Get in touch &rarr;', SITE + '/contact/'],
]
json.dump(b, open(sys.argv[1], 'w'), ensure_ascii=True)
