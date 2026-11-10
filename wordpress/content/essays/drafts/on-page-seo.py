"""Builds content/essays/on-page-seo.json from the Gate 2 review doc (9 Nov 2026).
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
    ['On-page SEO elements, sorted by job', 'rank-click-quote'],
    ['Rank: help Google understand the page', 'rank'],
    ['Click: help a person choose you', 'click'],
    ['Quote: help an AI lift one sentence', 'quote'],
    ['How to tell which on-page SEO job is failing', 'which-job'],
    ["What on-page SEO can't fix", 'limits'],
    ['The 15-minute on-page SEO checklist I run on every post', 'checklist'],
    ['Frequently asked questions', 'faq'],
]

b = [
 ['p', "<strong>On-page SEO is everything you control on the page itself: the words, headings, title tag, meta description, links and markup. It has three jobs. Help Google rank the page, help a person click it, and help an AI quote it. Most checklists list seventeen tasks as if they were one job, which is how teams end up rewriting meta descriptions to fix a ranking problem.</strong>"],
 ['p', "Below is the map I use to sort every on-page element by the job it actually does, how to tell which job is failing on a page, and the 15-minute pass I run on every post on this site."],
 ['box', 'Key takeaways', 'ul', [
   "On-page SEO has three jobs: Rank (Google understands the page), Click (a person chooses it) and Quote (an AI can lift a sentence from it).",
   "Most elements are good at one job. Fix the job that's failing, not the whole checklist.",
   "Meta descriptions don't help you rank, and schema doesn't help you get quoted. Both still earn their place, doing their own job.",
   "Google says AI Overviews need no special optimisation. The Quote job is writing discipline: answer first, under a heading that matches the question."]],
 ['toc', 'In this article', toc],

 ['h2', toc[0][0], toc[0][1]],
 ['p', "On-page SEO is the optimisation you do inside a page: its content, title tag, meta description, headings, URL, internal links, images and structured data. Technical SEO sits underneath it (can search engines reach and render the page?). Off-page SEO sits around it (do other sites vouch for you?)."],
 ['p', "In my " + a('Four-Question Test', SITE + '/what-is-seo/') + ", on-page SEO answers two of the four questions: can search engines understand the page, and will a person choose it? Find and Trust are other people's jobs."],
 ['p', "What most definitions miss is that a page now has three readers:"],
 ['ul', [
   "<strong>A crawler</strong>, deciding what the page is about.",
   "<strong>A person on a results page</strong>, deciding whether to click.",
   "<strong>An AI system</strong>, deciding whether one of your sentences is worth lifting into its answer."]],
 ['p', "They want different things."],
 ['quote', "One page, three readers, three jobs.", ''],

 ['h2', toc[1][0], toc[1][1]],
 ['p', "Every on-page element has a main job. Some do two. Very few do all three, and none does all three well."],
 ['callout', 'Framework', 'Rank, Click, Quote', 'ol', [
   "<strong>Rank:</strong> Can Google tell what this page is about, and which search it deserves to answer?",
   "<strong>Click:</strong> When it appears, will a person choose it over everything around it?",
   "<strong>Quote:</strong> Can an AI system lift one sentence from it that still makes sense on its own?"]],
 ['p', "Here is how the usual checklist sorts once you ask what each item is actually for."],
 ['table', ['Element', 'Main job', 'What to check', 'Common mistake'], [
   ['<strong>Search intent and page type</strong>', 'Rank', 'One page per intent, in the format Google already shows for that search', 'A long guide where Google shows service pages, or the reverse'],
   ['<strong>Body copy</strong>', 'Rank', "Your customers' words, not your organisation's", 'Internal jargon nobody searches for'],
   ['<strong>Subheadings (H2, H3)</strong>', 'Rank, Quote', 'Each names a real sub-question', 'Clever headings that mean nothing out of context'],
   ['<strong>Internal links</strong>', 'Rank', 'Descriptive anchors, to and from related pages', 'Orphan pages, and "click here"'],
   ['<strong>Schema markup</strong>', 'Rank', "Valid, and matches what's visible on the page", 'Selling it as an AI citation fix'],
   ['<strong>Image alt text</strong>', 'Rank', "Describes the image for someone who can't see it", 'Keywords stuffed in'],
   ['<strong>SEO title (title tag)</strong>', 'Rank, Click', 'Topic early, a reason to click, 50 to 60 characters', 'Three keyword variants and a pipe'],
   ['<strong>Meta description</strong>', 'Click', 'Reads like the answer or the argument', 'Treating it as a ranking lever'],
   ['<strong>URL slug</strong>', 'Click', 'Short enough to read aloud', 'Dates, IDs and every stop word'],
   ['<strong>H1</strong>', 'Click', "Tells the person who clicked they're in the right place", 'A label like "Blog" or "Services"'],
   ['<strong>Opening 100 words</strong>', 'Quote', 'Answers the core question directly', 'Three paragraphs of warm-up'],
   ['<strong>Self-contained sections and FAQ</strong>', 'Quote', 'Each answer makes sense if quoted alone', 'An FAQ that repeats the post']]],
 ['cite', "Source: author's framework."],
 ['p', "Read down the last column. Almost every common mistake is an element being asked to do a job it was never good at."],

 ['h2', toc[2][0], toc[2][1]],
 ['p', "The Rank job is an understanding problem. Google has to work out what your page is about and which search it should answer. Most of that comes from the words on the page and the links around it, not from tags."],
 ['p', "Start with intent. Search the query you want and look at what's already there. If Google shows service pages and you've written a 2,000-word guide, no amount of tag tuning closes that gap. You've built the wrong page."],
 ['p', "Then the words. In " + a('What is SEO?', SITE + '/what-is-seo/') + " I told the story of a healthcare site that described its services in its own language while patients searched in theirs. The fix wasn't a tag. It was rewriting the pages in the patients' words."],
 ['p', "Headings and internal links do the rest. A heading that names a real sub-question tells Google how the page is organised. A descriptive internal link tells it what the destination is about before it arrives."],
 ['p', "Schema belongs here too, as an understanding lever. It tells machines, in a fixed vocabulary, who you are and what the page describes. What it doesn't do is get you quoted. Google says there's " + a('no special schema needed for its AI features', G_AI) + ", and " + a("Ahrefs' May 2026 study", AHREFS_SCHEMA) + " tracked 1,885 pages that added JSON-LD against 4,000 that didn't. AI Overview citations fell 4.6%, and AI Mode and ChatGPT moved about 2%, which is noise. One caveat: every page in that study was already being cited. I've written about why schema is still worth doing as " + a("your website's resume", SITE + '/schema-markup-ai-visibility/') + "."],
 ['p', "<strong>Rank is mostly an understanding problem, and understanding is mostly words.</strong>"],

 ['h2', toc[3][0], toc[3][1]],
 ['p', "The Click job happens on a results page in about a second. Your title link, URL and snippet are the whole pitch, and Google rewrites them when it thinks it knows better."],
 ['p', "The meta description is a Click lever, not a Rank lever. Google builds snippets mainly from the page content and only uses your meta description when it describes the page better. So write it as the answer or the argument, not a place to park keywords."],
 ['p', "The title tag is the awkward one, because it does two jobs. It's a strong signal of what the page is about, and it's the headline a person reads on the results page. That tension is why every post on this site has two titles. The H1 is the argument, written for someone who has already clicked: \"Schema markup is your website's resume.\" The SEO title carries the topic and a promise, for someone still deciding: \"Schema Markup for AI Visibility: 5 Simple Fixes.\" This post does the same."],
 ['p', "If Google keeps rewriting your title, read it as feedback. " + a("Google's documentation on title links", G_TITLE) + " lists the sources it draws on, including your H1 and the anchor text of links pointing at the page. A rewrite usually means your title tag and your page disagree about what the page is."],
 ['p', "<strong>The Click job is a pitch, not a tag. Write it for someone tired, on a phone, comparing you with five other results.</strong>"],

 ['h2', toc[4][0], toc[4][1]],
 ['p', "The Quote job is new, and simpler than the GEO industry suggests. AI answers lift passages, not pages. Your job is to make sure there's a passage worth lifting."],
 ['p', "Google's " + a('May 2026 guide to generative AI features', G_GENAI) + " is plain about it: optimising for AI search is still SEO, and you don't need special files, markup or chunking tricks to appear. What's left is writing discipline."],
 ['p', "I learned that at Reem Hospital in Abu Dhabi. Our pages were cited in AI Overviews for head terms like \"pulmonologist\", next to Cleveland Clinic, on a domain with a Moz DA of 17. We didn't outrank them. Every cited passage was a short, self-contained answer sitting directly under a heading that matched the query."],
 ['p', "Quote isn't Rank under another name, either. Ahrefs' March 2026 analysis found only 38% of pages cited in AI Overviews ranked in Google's top 10. A page can lose the ranking and still win the sentence."],
 ['p', "<strong>If a sentence only makes sense with the paragraph above it, an AI will skip it.</strong>"],
 ['tip', 'Related essay', a('How to rank in AI Overviews: what I learned getting cited', SITE + '/rank-in-ai-overviews/') + ". The LIFT test I use to make an existing page citation-ready, with six real AI Overview citations."],

 ['h2', toc[5][0], toc[5][1]],
 ['p', "Most on-page audits fix everything at once, so nobody learns what worked. Diagnose first. Search Console will tell you which job is failing on a page."],
 ['table', ['What you see', 'Job failing', 'Fix first'], [
   ['Few impressions for the searches you want', '<strong>Rank</strong>', 'Intent, then the words, then headings and internal links'],
   ['Impressions, but click-through rate below pages at similar positions on your site', '<strong>Click</strong>', 'SEO title, then meta description'],
   ['Ranking and getting clicks, but missing from the AI Overview for your core question', '<strong>Quote</strong>', 'The first 100 words, then the first sentence under each H2']]],
 ['cite', "Source: author's framework."],
 ['p', "Fix one job at a time and note the date. A few weeks later, you'll know which change did it."],
 ['note', 'What to do on Monday', 'ul', [
   "Open Search Console, go to Performance and look at your pages.",
   "Pick the three pages that matter most to the business, not the three with the most traffic.",
   "For each, use the table above to decide which job is failing, and fix only that job this week."]],

 ['h2', toc[6][0], toc[6][1]],
 ['p', "On-page SEO makes a good page easy to understand, choose and quote. It has limits."],
 ['ul', [
   "<strong>It can't fix a page Google can't reach.</strong> If the page isn't crawled or indexed, that's technical SEO.",
   "<strong>It can't manufacture trust.</strong> You can show who wrote the page and what they've done, but authority comes from other sites, reviews and mentions.",
   "<strong>It can't rescue a weak offer.</strong> A perfect title on a page nobody wants still loses the click."]],
 ['p', "In healthcare there's one more limit. Never sharpen a medical sentence beyond what the clinician has signed off, just to win a snippet. A quotable sentence that's wrong gets quoted too."],
 ['p', "<strong>On-page SEO makes a good page legible. It can't make a bad page good.</strong>"],

 ['h2', toc[7][0], toc[7][1]],
 ['p', "Ten questions, grouped by job."],
 ['callout', 'Checklist', 'Rank, Click, Quote: ten questions', 'ol', [
   "<strong>Rank.</strong> Is my page the format Google already shows for the target search?",
   "<strong>Rank.</strong> Read the opening aloud. Does it use the words a customer would type?",
   "<strong>Rank.</strong> Does every H2 name a real sub-question?",
   "<strong>Rank.</strong> Are there two or three internal links in, with descriptive anchors, including one from an older related post?",
   "<strong>Click.</strong> Does the SEO title put the topic first and a reason to click second, in roughly 50 to 60 characters?",
   "<strong>Click.</strong> Does the meta description state the argument in about 150 characters?",
   "<strong>Click.</strong> Is the slug short enough to say out loud?",
   "<strong>Quote.</strong> Is the core question answered in the first 100 words?",
   "<strong>Quote.</strong> Does the first sentence of each section make sense on its own?",
   "<strong>Quote.</strong> Are FAQ answers 40 to 60 words, and readable without the rest of the post?"]],
 ['p', "If a page fails a whole group, that's this week's work. If it passes all ten and still isn't performing, the problem probably isn't on the page."],

 ['h2', toc[8][0], toc[8][1]],
 ['h3s', 'How long does on-page SEO take to show results?'],
 ['p', "It depends on the change. " + a("Google's SEO Starter Guide", G_START) + " says some changes take effect in a few hours and others take several months, and suggests waiting a few weeks before judging your work. Title and snippet changes usually surface first. Changes to what a page is about take longer, because Google has to recrawl and reassess it."],
 ['h3s', 'Does word count matter for on-page SEO?'],
 ['p', "Not directly. Google's John Mueller has said plainly that word count is not a ranking factor. Length should follow the question: a definition needs a paragraph, a how-to may need two thousand words. Padding a page to match competitors usually buries the answer, which hurts both the Click and the Quote jobs."],
 ['h3s', 'How many keywords should one page target?'],
 ['p', "One main intent, not one keyword. A page can rank for dozens of related searches if they share the same intent, so write naturally around the main phrase and its close variants. If two keywords need different answers or a different page format, they need different pages, not a longer one."],
 ['h3s', 'Should you fix old pages or write new ones first?'],
 ['p', "Usually fix the old ones. A page that already gets impressions gives you data, so you can see which job is failing and fix only that. A new page starts from zero. Leave pages that already perform well alone, as Google itself recommends, and use the checklist on everything new you publish."],
 ['h3s', 'What is the difference between on-page and off-page SEO?'],
 ['p', "On-page SEO is everything you control on the page itself: the words, headings, title tag, meta description, internal links and markup. Off-page SEO is what happens elsewhere: backlinks, mentions and reviews that tell search engines other people trust you. You need both. On-page work makes a page worth trusting, and off-page work is how that trust gets earned."],
 ['cta', "Which job is failing on your most important page?", "If you've seen an on-page element do a job I haven't mapped here, I'd like to hear about it.", 'Get in touch &rarr;', SITE + '/contact/', 'Continue the conversation on LinkedIn &rarr;', 'https://www.linkedin.com/in/vineetvijay'],
]
json.dump(b, open(sys.argv[1], 'w'), ensure_ascii=True)
