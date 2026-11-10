"""Builds content/essays/on-page-seo.json from the approved rewrite (review doc, 10 Nov 2026).
Usage: python3 on-page-seo.py <out.json>"""
import json, sys

def a(text, href):
    return '<a href="%s">%s</a>' % (href, text)

SITE = 'https://vineetonmarketing.com'
G_AI = 'https://developers.google.com/search/docs/appearance/ai-features'
G_GENAI = 'https://developers.google.com/search/docs/fundamentals/ai-optimization-guide'
G_TITLE = 'https://developers.google.com/search/docs/appearance/title-link'
G_START = 'https://developers.google.com/search/docs/fundamentals/seo-starter-guide'
AHREFS_SCHEMA = 'https://ahrefs.com/blog/schema-ai-citations/'

toc = [
    ['What is on-page SEO?', 'what-is-on-page-seo'],
    ['Why on-page SEO matters', 'why-it-matters'],
    ['The key on-page SEO elements', 'elements'],
    ['How to do on-page SEO, step by step', 'how-to'],
    ['On-page SEO best practices', 'best-practices'],
    ['For experienced readers: Rank, Click, Quote', 'rank-click-quote'],
    ['Advanced on-page SEO', 'advanced'],
    ["Common on-page SEO mistakes, and what it can't fix", 'mistakes'],
    ['The on-page SEO checklist', 'checklist'],
    ['Frequently asked questions', 'faq'],
]

def bp(text):
    return ['p', '<strong>Best practice:</strong> ' + text]

b = [
 ['p', "<strong>On-page SEO is the work you do on the page itself so that search engines understand it, people choose it in the results and AI tools can quote it. It covers the content, the title tag, the meta description, headings, the URL, internal links, images and structured data. Last week I changed one title on this site because a keyword tool showed the topic had almost four times the searches under a different name. That is on-page SEO in one small decision.</strong>"],
 ['p', "That's the short answer. Here's what on-page SEO includes, how to get each element right, the step-by-step process I use on every post, and, if you've done this for years, the framework I use to find what's actually broken."],
 ['box', 'Key takeaways', 'ul', [
   "On-page SEO is everything you control on the page: the words, title tag, meta description, headings, URL, links, images and markup.",
   "Start with search intent. A page in the wrong format won't rank, however well you tune its tags.",
   "The title tag and the opening paragraph do the most work. The meta description helps people click, not the page rank.",
   "Every element has a main job: helping Google rank the page, helping a person click it, or helping an AI quote it.",
   "Fix one thing at a time, then wait a few weeks before you judge it. Google says some changes take months to show."]],
 ['toc', 'In this article', toc],

 # 1
 ['h2', toc[0][0], toc[0][1]],
 ['p', "On-page SEO (also called on-site SEO) is the optimisation you do inside a single page: its content, title tag, meta description, headings, URL, internal links, images and structured data. The aim is simple. When someone searches for what the page covers, search engines should understand it, rank it and show it in a way that makes people want to click."],
 ['p', "It's one of three parts of SEO, and the easiest way to understand it is next to the other two."],
 ['table', ['Type of SEO', 'What it covers', 'Who usually owns it'], [
   ['<strong>On-page SEO</strong>', 'The content and the elements on each page: words, titles, headings, links, images, markup', 'Writers, marketers, SEO specialists'],
   ['<strong>Technical SEO</strong>', 'Whether search engines can reach, render and index the site: crawling, speed, mobile, redirects', 'Developers, technical SEO'],
   ['<strong>Off-page SEO</strong>', 'What other sites say about you: backlinks, mentions, reviews', 'PR, partnerships, the brand itself']]],
 ['cite', "Source: author's summary."],
 ['p', "In my " + a('Four-Question Test', SITE + '/what-is-seo/') + ", on-page SEO answers two of the four questions: can search engines understand the page, and will a person choose it? Technical SEO answers Find. Off-page SEO answers Trust."],
 ['p', "<strong>On-page SEO is the part of SEO you fully control, which is why it's the best place to start.</strong>"],

 # 2
 ['h2', toc[1][0], toc[1][1]],
 ['p', "On-page SEO matters because it decides whether a page is understood, chosen and quoted, and you can change it today without anyone's permission."],
 ['p', "What most definitions miss is that a page now has three readers:"],
 ['ul', [
   "<strong>A crawler</strong>, deciding what the page is about.",
   "<strong>A person on a results page</strong>, deciding whether to click.",
   "<strong>An AI system</strong>, deciding whether one of your sentences is worth lifting into its answer."]],
 ['p', "They want different things, and a page that serves only one of them leaves results on the table. A page Google understands but nobody clicks earns impressions and no visits. A page people would love but Google can't place never gets shown."],
 ['quote', "One page, three readers, three jobs.", ''],

 # 3
 ['h2', toc[2][0], toc[2][1]],
 ['p', "There are eleven on-page SEO elements worth your time. Here they are at a glance, then one by one."],
 ['table', ['Element', 'What it is', 'Best practice in one line'], [
   ['<strong>Search intent and content</strong>', 'What the searcher wants, and the page you wrote for it', 'Match the format Google already shows for the search'],
   ['<strong>Target keyword and topic</strong>', 'The main search the page is for, and the questions around it', 'One page per intent, covering the sub-questions people ask'],
   ['<strong>Title tag</strong>', 'The clickable headline in search results (the SEO title)', 'Topic first, a reason to click, about 50 to 60 characters'],
   ['<strong>Meta description</strong>', 'The short summary that can appear under the title', 'State the answer or the argument in about 150 characters'],
   ['<strong>H1 and subheadings</strong>', "The page's main heading and the H2s and H3s under it", 'One clear H1; each H2 names a real sub-question'],
   ['<strong>URL slug</strong>', 'The words after your domain', 'Short, readable, no dates or IDs'],
   ['<strong>Opening paragraph</strong>', 'The first 60 to 100 words', 'Answer the main question directly'],
   ['<strong>Internal links</strong>', 'Links from your other pages to this one, and from it to them', 'Descriptive anchor text, from related pages'],
   ['<strong>Images and alt text</strong>', 'Pictures on the page and the text that describes them', 'Describe the image; compress it; name the file clearly'],
   ['<strong>Structured data</strong>', 'Code (usually JSON-LD) that labels what the page describes', "Valid, and only what's visible on the page"],
   ['<strong>Trust signals</strong>', 'Author, sources, dates, first-hand experience', 'Show who wrote it and where the facts came from']]],
 ['cite', "Source: author's summary."],

 ['h3s', '1. Search intent and content'],
 ['p', "Search intent is what the person typing the query actually wants: a definition, a how-to, a comparison, a product, a local business. It decides the format of the page that can rank. Search the query yourself and look at what's there. If Google shows service pages and you've written a 2,000-word guide, no amount of tag tuning closes that gap."],
 bp("before you write a word, note the page type, length and angle of the top five results."),

 ['h3s', '2. Target keyword and topic coverage'],
 ['p', "The target keyword is the main search the page is built for. Use it, and the words your customers use, naturally in the title, the opening, at least one heading and the body. Then cover the questions around it, because Google matches a page to many related searches, not one phrase."],
 ['p', "In " + a('What is SEO?', SITE + '/what-is-seo/') + " I told the story of a healthcare site that described its services in its own language while patients searched in theirs. The fix was rewriting the pages in the patients' words."],
 bp("one main intent per page. If two keywords need different answers, they need different pages."),

 ['h3s', '3. Title tag'],
 ['p', "The title tag is the headline people see in search results, and one of the strongest signals of what the page is about. It's separate from the H1 on the page, so you can write each for its own reader. Google may rewrite it: " + a("Google's documentation on title links", G_TITLE) + " lists the sources it draws on, including your H1 and the anchor text of links pointing at the page."],
 bp("put the topic first and a reason to click second, in roughly 50 to 60 characters. Every page gets a unique title."),

 ['h3s', '4. Meta description'],
 ['p', "The meta description is a short summary that Google sometimes shows under your title. It helps people decide to click; it isn't a ranking lever. " + a("Google's SEO Starter Guide", G_START) + " says snippets come mainly from the page content, and a good meta description is \"short, unique to one particular page, and includes the most relevant points of the page.\""],
 bp("write it as the answer or the argument, in about 150 characters, with the keyword near the start."),

 ['h3s', '5. H1 and subheadings'],
 ['p', "The H1 is the main heading on the page, and it tells the person who clicked that they're in the right place. Subheadings (H2, H3) break the page into sections and tell Google how it's organised. A heading that names a real sub-question also gives AI tools a clean place to find an answer."],
 bp("one H1, and H2s that use the words people search. Google says heading order doesn't matter for ranking, but it does for screen readers, so keep it logical."),

 ['h3s', '6. URL slug'],
 ['p', "The slug is the part of the URL after your domain, such as /on-page-seo/. Google can show parts of the URL in results as breadcrumbs, so people read it too."],
 bp("short enough to say out loud, with the main keyword, and no dates, IDs or filler words. Set it right at launch, because changing it later means a redirect."),

 ['h3s', '7. Opening paragraph'],
 ['p', "The first 60 to 100 words carry more weight than any other part of the copy. Readers decide whether to stay, and AI answers often lift the clearest early sentence."],
 bp("answer the main question in the first two sentences. Context and story come after the answer, not before it."),

 ['h3s', '8. Internal links'],
 ['p', "Internal links connect your pages. They help Google find new pages, understand what each one is about, and see which pages matter most. The anchor text (the clickable words) tells both people and Google what's on the other side."],
 bp("link every new page from two or three related older pages, with descriptive anchors such as \"on-page SEO checklist\", never \"click here\"."),

 ['h3s', '9. Images and alt text'],
 ['p', "Alt text is a short description of an image for people who can't see it, and Google uses it to understand the image and its context. File names and file size matter too: a clear name helps, and a heavy image slows the page."],
 bp("describe what the image shows in one plain sentence, include the topic where it fits naturally, and compress images before upload (WebP works well)."),

 ['h3s', '10. Structured data'],
 ['p', "Structured data, or schema markup, is code that labels what a page describes: an article, a person, a business, a product, an FAQ. It helps machines read your page without guessing. It doesn't get you quoted by AI on its own, a point I cover in " + a("Schema is your website's resume", SITE + '/schema-markup-ai-visibility/') + "."],
 bp("mark up only what's visible on the page, and validate it with Google's Rich Results Test."),

 ['h3s', '11. Trust signals'],
 ['p', "Trust signals show who wrote the page and why they're worth reading: a named author with relevant experience, linked sources, a visible date, first-hand detail. Google's quality raters look for experience, expertise, authoritativeness and trustworthiness (E-E-A-T). Google says E-E-A-T itself is not a ranking factor, but the things it describes make content better."],
 bp("a real byline, sources linked where facts appear, and at least one detail only you could know."),

 # 4
 ['h2', toc[3][0], toc[3][1]],
 ['p', "You can optimise a page in seven steps, and the same steps work for a new post or a page that has stopped performing."],
 ['ol', [
   "<strong>Pick one page and one search.</strong> Start with a page that matters to the business, and decide the single search it should answer.",
   "<strong>Study the results page.</strong> Search it yourself. Note the type of page that ranks, the questions under \"People also ask\", and whether an AI Overview appears.",
   "<strong>Map the keywords.</strong> List the main phrase, its close variants and the questions around it. Check that no other page on your site targets the same thing.",
   "<strong>Write, or rewrite, answer first.</strong> Answer the main question in the opening, in your customers' words. Give each sub-question its own heading.",
   "<strong>Optimise the elements.</strong> Title tag, meta description, H1, slug, image names and alt text, and schema, using the best practices above.",
   "<strong>Link it in.</strong> Add links from two or three related pages on your site, with anchor text that names the topic.",
   "<strong>Publish, then measure.</strong> Request indexing in Google Search Console's URL Inspection tool, note the date, and judge the change after a few weeks, not a few days."]],
 ['brief', 'Worked example', 'The title I changed last week', [
   ['p', "I published " + a('What is SEO?', SITE + '/what-is-seo/') + " on 2 November with the SEO title \"What Is SEO? A Simple Guide to How Search Engines Work\". Two days later, a keyword tool showed \"what is SEO\" at about 500 searches a month and \"search engine optimization\" at 1.9K, with pages ranking for one usually ranking for the other."],
   ['p', "So I went back to step 3. The title became \"What Is SEO? Search Engine Optimisation Explained Simply\", the meta description named both, and a short section answered a third search, \"what is SEO in digital marketing\". Three older posts got links pointing to it. Nothing else changed, so in a few weeks Search Console will tell me whether it worked."]]],
 ['p', "<strong>Most on-page SEO isn't new pages. It's going back to the page you already have with better information.</strong>"],

 # 5
 ['h2', toc[4][0], toc[4][1]],
 ['p', "The best practices that matter most are about clarity, not tricks. These are the ones I hold every page to."],
 ['ul', [
   "<strong>Write for one intent per page.</strong> Two pages chasing the same search compete with each other.",
   "<strong>Answer first.</strong> The opening and the first sentence under each heading should make sense if quoted alone.",
   "<strong>Use your customers' words.</strong> Internal jargon is the most common reason a good page doesn't rank.",
   "<strong>Make every title and meta description unique.</strong> Duplicates make pages look interchangeable, to people and to Google.",
   "<strong>Link new pages from old ones.</strong> A page with no internal links pointing to it is hard for Google to find and rank.",
   "<strong>Keep the page honest.</strong> Schema, headings and titles should describe what's actually on the page.",
   "<strong>Update, don't just publish.</strong> Revisit pages that already get impressions before writing new ones.",
   "<strong>Change one thing at a time.</strong> Otherwise you'll never know which change worked."]],
 ['brief', 'From Google', 'What Google says not to worry about', [
   ['p', a("Google's SEO Starter Guide", G_START) + " lists several things people still spend time on that make little or no difference:"],
   ['ul', [
     "<strong>Meta keywords.</strong> Google Search doesn't use the keywords meta tag.",
     "<strong>Keyword stuffing.</strong> Repeating the same words is against Google's spam policies.",
     "<strong>Word count.</strong> There's no minimum or maximum length for ranking.",
     "<strong>Heading order.</strong> Out-of-order headings don't affect ranking, though they matter for screen readers.",
     "<strong>E-E-A-T as a score.</strong> Google says it isn't a ranking factor."]]]],

 # 6
 ['h2', toc[5][0], toc[5][1]],
 ['p', "If you've run on-page SEO for years, the elements above won't be new. What I find more useful is sorting them by the job each one does, because most audits fix everything at once and nobody learns what worked."],
 ['callout', 'Framework', 'Rank, Click, Quote', 'ol', [
   "<strong>Rank:</strong> Can Google tell what this page is about, and which search it deserves to answer?",
   "<strong>Click:</strong> When it appears, will a person choose it over everything around it?",
   "<strong>Quote:</strong> Can an AI system lift one sentence from it that still makes sense on its own?"]],
 ['p', "Every element has a main job. Some do two. None does all three well."],
 ['table', ['Element', 'Main job', 'Common mistake'], [
   ['<strong>Search intent and content</strong>', 'Rank', 'A long guide where Google shows service pages'],
   ['<strong>Target keyword and topic</strong>', 'Rank', 'Two pages chasing the same search'],
   ['<strong>Internal links</strong>', 'Rank', 'Orphan pages, and "click here"'],
   ['<strong>Structured data</strong>', 'Rank', 'Selling it as an AI citation fix'],
   ['<strong>Images and alt text</strong>', 'Rank', 'Keywords stuffed into alt text'],
   ['<strong>Title tag</strong>', 'Rank, Click', 'Three keyword variants and a pipe'],
   ['<strong>Meta description</strong>', 'Click', 'Treating it as a ranking lever'],
   ['<strong>URL slug</strong>', 'Click', 'Dates, IDs and every stop word'],
   ['<strong>H1 and subheadings</strong>', 'Click, Quote', 'Clever headings that mean nothing out of context'],
   ['<strong>Opening paragraph</strong>', 'Quote', 'Three paragraphs of warm-up'],
   ['<strong>Trust signals</strong>', 'Click, Quote', 'No author, no sources']]],
 ['cite', "Source: author's framework."],
 ['h3s', 'How to tell which job is failing'],
 ['p', "Google Search Console will tell you, page by page."],
 ['table', ['What you see', 'Job failing', 'Fix first'], [
   ['Few impressions for the searches you want', '<strong>Rank</strong>', 'Intent, then the words, then headings and internal links'],
   ['Impressions, but click-through rate below pages at similar positions on your site', '<strong>Click</strong>', 'SEO title, then meta description'],
   ['Ranking and getting clicks, but missing from the AI Overview for your core question', '<strong>Quote</strong>', 'The first 100 words, then the first sentence under each H2']]],
 ['cite', "Source: author's framework."],
 ['note', 'What to do on Monday', 'ul', [
   "Open Search Console, go to Performance and look at your pages.",
   "Pick the three pages that matter most to the business, not the three with the most traffic.",
   "For each, use the table above to decide which job is failing, and fix only that job this week."]],

 # 7
 ['h2', toc[6][0], toc[6][1]],
 ['p', "Once the basics are in place, these are the four problems I see most on mature sites."],
 ['h3s', 'Keyword cannibalisation'],
 ['p', "Cannibalisation is when two or more of your pages target the same search, so Google keeps switching between them and neither ranks well. In Search Console, filter Performance by the query and look at the Pages tab. If two URLs take turns, pick one to keep, merge the useful parts of the other into it, and redirect or re-angle the loser."],
 ['h3s', 'When Google rewrites your title'],
 ['p', "If Google keeps showing a different title from the one you wrote, read it as feedback. A rewrite usually means your title tag and your page disagree about what the page is. Bring the title closer to the H1 and the opening, or the other way round, rather than fighting the rewrite."],
 ['h3s', 'Getting quoted in AI answers'],
 ['p', "The Quote job is new, and simpler than the GEO industry suggests. Google's " + a('May 2026 guide to generative AI features', G_GENAI) + " is plain about it: optimising for AI search is still SEO, and you don't need special files, markup or chunking tricks to appear."],
 ['p', "I learned that at Reem Hospital in Abu Dhabi. Our pages were cited in AI Overviews for head terms like \"pulmonologist\", next to Cleveland Clinic, on a domain with a Moz DA of 17. We didn't outrank them. Every cited passage was a short, self-contained answer sitting directly under a heading that matched the query."],
 ['p', "Quote isn't Rank under another name, either. Ahrefs' March 2026 analysis found only 38% of pages cited in AI Overviews ranked in Google's top 10."],
 ['p', "<strong>If a sentence only makes sense with the paragraph above it, an AI will skip it.</strong>"],
 ['tip', 'Related essay', a('How to rank in AI Overviews: what I learned getting cited', SITE + '/rank-in-ai-overviews/') + ". The LIFT test I use to make an existing page citation-ready, with six real AI Overview citations."],
 ['h3s', "Schema: what it does and doesn't do"],
 ['p', "Schema helps machines understand a page, but the evidence that it earns AI citations is weak. Google says there's " + a('no special schema needed for its AI features', G_AI) + ", and " + a("Ahrefs' May 2026 study", AHREFS_SCHEMA) + " tracked 1,885 pages that added JSON-LD against 4,000 that didn't. AI Overview citations fell 4.6%, and AI Mode and ChatGPT moved about 2%, which is noise. One caveat: every page in that study was already being cited. Do schema for understanding and rich results, not as a citation fix."],
 ['h3s', 'Internal linking at scale'],
 ['p', "On a site with dozens or hundreds of pages, internal links are how you tell Google which pages matter most. Group pages into topics, with one main guide per topic linking out to the detailed pages and each of them linking back. Then check for orphan pages, the ones with no internal links pointing at them; most SEO plugins and crawlers list them."],

 # 8
 ['h2', toc[7][0], toc[7][1]],
 ['p', "Most on-page SEO mistakes come from asking an element to do a job it was never good at."],
 ['ul', [
   "<strong>Rewriting meta descriptions to fix rankings.</strong> It changes clicks, not positions.",
   "<strong>Writing for the organisation, not the customer.</strong> Your page uses your service names; your customers search in theirs.",
   "<strong>Warming up before the answer.</strong> Three paragraphs of context push the answer below where readers and AI look.",
   "<strong>Publishing and never linking.</strong> A new page with no internal links in is close to invisible.",
   "<strong>Treating schema as a shortcut.</strong> It describes the page; it doesn't make the page better.",
   "<strong>Changing everything at once.</strong> You can't learn from a test with ten variables."]],
 ['p', "On-page SEO also has limits, and it's worth being honest about them:"],
 ['ul', [
   "<strong>It can't fix a page Google can't reach.</strong> If the page isn't crawled or indexed, that's technical SEO.",
   "<strong>It can't manufacture trust.</strong> Authority comes from other sites, reviews and mentions.",
   "<strong>It can't rescue a weak offer.</strong> A perfect title on a page nobody wants still loses the click."]],
 ['p', "In healthcare there's one more limit. Never sharpen a medical sentence beyond what the clinician has signed off, just to win a snippet. A quotable sentence that's wrong gets quoted too."],
 ['p', "<strong>On-page SEO makes a good page legible. It can't make a bad page good.</strong>"],

 # 9
 ['h2', toc[8][0], toc[8][1]],
 ['p', "This is the 15-minute pass I run on every post on this site: twelve questions, grouped by job."],
 ['callout', 'Checklist', 'Rank, Click, Quote: twelve questions', 'ol', [
   "<strong>Rank.</strong> Is my page the format Google already shows for the target search?",
   "<strong>Rank.</strong> Is this the only page on my site aimed at that search?",
   "<strong>Rank.</strong> Read the opening aloud. Does it use the words a customer would type?",
   "<strong>Rank.</strong> Does every H2 name a real sub-question?",
   "<strong>Rank.</strong> Are there two or three internal links in, with descriptive anchors, including one from an older related post?",
   "<strong>Rank.</strong> Do images have clear file names, descriptive alt text and a sensible file size?",
   "<strong>Click.</strong> Does the SEO title put the topic first and a reason to click second, in roughly 50 to 60 characters?",
   "<strong>Click.</strong> Does the meta description state the answer or argument in about 150 characters?",
   "<strong>Click.</strong> Is the slug short enough to say out loud?",
   "<strong>Quote.</strong> Is the core question answered in the first 100 words?",
   "<strong>Quote.</strong> Does the first sentence of each section make sense on its own?",
   "<strong>Quote.</strong> Is there a named author, a date, and a source beside every number?"]],
 ['p', "If a page fails a whole group, that's this week's work. If it passes all twelve and still isn't performing, the problem probably isn't on the page."],
 ['tip', 'Bonus Tip: read your result like a stranger', "Before you publish, paste the SEO title, the URL and the meta description into a note on your phone, one under the other. Read them as someone comparing you with five other results. If you wouldn't click, rewrite the title before you touch anything else."],

 # FAQ
 ['h2', toc[9][0], toc[9][1]],
 ['h3s', 'What are the most important on-page SEO factors?'],
 ['p', "In my experience, search intent, the content itself, the title tag, the opening paragraph, headings and internal links do most of the work. Get the page type right for the search first, then make sure the title and first 100 words name the topic in your customers' words. Meta descriptions, alt text and schema matter, but they rarely rescue a page that gets those basics wrong."],
 ['h3s', 'What is the difference between on-page and off-page SEO?'],
 ['p', "On-page SEO is everything you control on the page itself: the words, headings, title tag, meta description, internal links and markup. Off-page SEO is what happens elsewhere: backlinks, mentions and reviews that tell search engines other people trust you. You need both. On-page work makes a page worth trusting, and off-page work is how that trust gets earned."],
 ['h3s', 'How long does on-page SEO take to show results?'],
 ['p', "It depends on the change. " + a("Google's SEO Starter Guide", G_START) + " says some changes take effect in a few hours and others take several months, and suggests waiting a few weeks before judging your work. Title and snippet changes usually surface first. Changes to what a page is about take longer, because Google has to recrawl and reassess it."],
 ['h3s', 'Does word count matter for on-page SEO?'],
 ['p', "Not on its own. Google's SEO Starter Guide says the length of the content alone doesn't matter for ranking, and there's no minimum or maximum word count. Length should follow the question: a definition needs a paragraph, a how-to may need two thousand words. Padding a page to match competitors usually buries the answer."],
 ['h3s', 'How many keywords should one page target?'],
 ['p', "One main intent, not one keyword. A page can rank for dozens of related searches if they share the same intent, so write naturally around the main phrase and its close variants. If two keywords need different answers or a different page format, they need different pages, not a longer one."],
 ['h3s', 'Should you fix old pages or write new ones first?'],
 ['p', "Usually fix the old ones. A page that already gets impressions gives you data, so you can see which job is failing and fix only that. A new page starts from zero. Leave pages that already perform well alone, and use the checklist on everything new you publish."],
 ['cta', "Which on-page SEO element is letting your most important page down?", "If you try the checklist, or find an element doing a job I haven't mapped here, write to me. I'd genuinely love to hear how it goes.", 'Get in touch &rarr;', SITE + '/contact/', 'Continue the conversation on LinkedIn &rarr;', 'https://www.linkedin.com/in/vineetvijay'],
]
json.dump(b, open(sys.argv[1], 'w'), ensure_ascii=True)
