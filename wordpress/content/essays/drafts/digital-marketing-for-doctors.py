import json,sys
U='https://vineetonmarketing.com'
def a(t,h): return f'<a href="{h}">{t}</a>'
b=[]
b.append(['p','<strong>{{C1}}The department\'s ads were doing their job. People clicked, and some filled in the form. But the consultation diary barely moved. When I looked closely, the ads weren\'t the problem. The landing page and the tracking were. So here\'s the short answer: a doctor\'s marketing plan should start at the booked appointment and work backwards. Make booking easy, make the page answer a nervous patient\'s questions, track consultations instead of clicks, and only then spend more on being found.</strong>'])
b.append(['p',"That's the short answer. Here's the story behind it, and the five-step plan I'd use if I were starting a doctor's marketing from scratch today. It works whether the doctor is a surgeon, a dentist or a GP, and you don't need a big budget to start."])
b.append(['box','Key takeaways','ul',[
 "A doctor's marketing plan exists to fill the appointment diary. Likes, clicks and form fills only matter if they turn into booked consultations.",
 "Start with the booking path: phone, WhatsApp, forms and how fast someone replies. Fixing this is usually cheaper than buying more traffic.",
 "The landing page has to answer a worried patient's questions about the doctor, the procedure, the process and the next step, in that order.",
 "Track consultations, not clicks. Feeding booked appointments back into Google Ads lets the platform optimise for patients instead of browsers.",
 "In the UAE, healthcare advertising has its own rules. Check the regulator's guidance before you write ad copy or post results."]])
toc=[["What is a digital marketing strategy for doctors actually for?","what-its-for"],["Start at the booking, not the ad","start-at-booking"],["Fix the page patients land on","landing-page"],["Track consultations, not clicks","track-consultations"],["Be findable and trusted, including in AI answers","findable-trusted"],["Paid media that books appointments","paid-media"],["Where this plan breaks","limits"],["Frequently asked questions","faq"]]
b.append(['toc','In this article',toc])
b.append(['h2','What is a digital marketing strategy for doctors actually for?','what-its-for'])
b.append(['p',"A doctor's marketing plan has one job: to fill the appointment diary with the right patients. Everything else is a means to that end."])
b.append(['p',"That sounds obvious. But look at most monthly reports for clinics and you'll see impressions, clicks, followers and \"leads\". You rarely see the one number the doctor cares about: how many consultations were booked, and how many of those people turned up."])
b.append(['p',"Here's the thing. A patient doesn't go from an ad to a surgery. They take a path, and they can drop off at every step."])
b.append(['callout','Framework','The Appointment Path','ol',[
 "<strong>Found.</strong> The patient can find the doctor when they search, on Google, on maps, in directories and in AI answers.",
 "<strong>Trusted.</strong> What they find makes them believe this doctor is qualified, real and right for their problem.",
 "<strong>Chosen.</strong> The page they land on answers their questions well enough that they want to take the next step.",
 "<strong>Booked.</strong> Taking that step is easy, and someone responds quickly enough that they don't go elsewhere.",
 "<strong>Kept.</strong> They turn up for the consultation, and the clinic knows which marketing brought them in."]])
b.append(['p',"<strong>Most doctors spend their budget on step one and lose patients at steps three, four and five.</strong>"])
b.append(['h2','Start at the booking, not the ad','start-at-booking'])
b.append(['p',"When a doctor tells me they need more patients, I don't start with the ads. I start at the end of the path, with the booking."])
b.append(['p',"The reason is simple. If the booking step leaks, more traffic just means more people leaking out of it. You pay more and the diary stays the same."])
b.append(['p',"So before touching a campaign, check how a patient actually books:"])
b.append(['ol',[
 "<strong>Call the number on the website and the Google Business Profile.</strong> Does someone answer? Is it the right clinic?",
 "<strong>Send a WhatsApp message.</strong> In the UAE, many patients prefer it to a call. How long does the reply take?",
 "<strong>Fill in the form on your phone.</strong> Is it short? Does it ask for things a patient doesn't know yet?",
 "<strong>Note what happens after hours.</strong> Plenty of people research a procedure late at night. Does anything happen before morning?",
 "<strong>Ask the front desk what they do with an enquiry.</strong> Who follows up, how many times, and where is it recorded?"]])
b.append(['p',"None of this needs a marketing budget. It needs an hour and a bit of honesty."])
b.append(['h2','Fix the page patients land on','landing-page'])
b.append(['p',"This is where the plastic surgeon's story starts."])
b.append(['p',"The ads were working in the way most reports measure. People clicked. Some filled in the form. But very few of those clicks turned into booked consultations."])
b.append(['p',"So I looked at the landing page the way a patient would.{{C2}}"])
b.append(['p',"Think about who is reading that page. Someone considering a cosmetic procedure is often nervous. They're comparing surgeons. They want to know who will operate, what the process looks like, and what happens if they have questions. A page that only says \"Book now\" asks for trust before it has earned any."])
b.append(['table',["What a nervous patient wants to know","What the page should show"],[
 ["Who is the doctor?","Name, photo, qualifications and speciality exactly as licensed"],
 ["Have they done this before?","Experience with this procedure, in plain words, without promising results"],
 ["What happens next?","The consultation steps: what it covers, how long it takes, what to bring"],
 ["Can I ask questions first?","A WhatsApp or call option next to the form, not only a form"],
 ["Is this place real?","Clinic address, map, reviews and the clinic's licence details"]]])
b.append(['cite',"Source: author's framework"])
b.append(['p',"We rebuilt the page around those questions.{{C3}}"])
b.append(['p',"{{C4}}"])
b.append(['p',"<strong>A landing page for a doctor isn't a brochure. It's the answer to a worried person's questions.</strong>"])
b.append(['h2','Track consultations, not clicks','track-consultations'])
b.append(['p',"The second problem was harder to see, because the reports looked fine."])
b.append(['p',"{{C5}} Google was doing exactly what it was asked to do: find more people likely to click or submit a form. Nobody had told it which of those people became patients."])
b.append(['p',"So the platform kept finding more browsers. Why wouldn't it?"])
b.append(['quote',"If you can't see which ad booked a consultation, you're paying Google to find you more people who click.",""])
b.append(['p',"The fix is to send the real outcome back to the ad platform. In Google Ads, you do this with offline conversion import, or its newer version, "+a('enhanced conversions for leads','https://support.google.com/google-ads/answer/11909980')+". It matches the leads in your records to the ad clicks that produced them, using hashed details such as an email address or phone number, so personal data isn't sent in plain text."])
b.append(['p',"Here's how I'd set it up for a clinic:"])
b.append(['ol',[
 "<strong>Capture the click.</strong> Make sure every form and WhatsApp enquiry is recorded with the date, the source and the contact details the patient gave.",
 "<strong>Mark the outcome.</strong> The front desk updates each enquiry: booked, attended, or not interested. A shared sheet is enough to start.",
 "<strong>Send it back.</strong> Upload booked and attended consultations to Google Ads as conversions, through enhanced conversions for leads or a regular import.",
 "<strong>Change the goal.</strong> Once enough consultations are flowing in, make the booked consultation the primary conversion, and treat form fills as secondary.",
 "<strong>Review weekly.</strong> Look at which campaigns, keywords and ads bring consultations, not just enquiries."]])
b.append(['p',"I wrote more about how Google is getting better at matching offline data in "+a('Customer Match just learned to read your server logs',U+'/customer-match-ip-timestamp/')+"."])
b.append(['p',"{{C6}}"])
b.append(['p',"<strong>Clicks tell you who was curious. Booked consultations tell you who was ready.</strong>"])
b.append(['h2','Be findable and trusted, including in AI answers','findable-trusted'])
b.append(['p',"Once the booking path, the page and the tracking work, it's worth spending more on being found. Not before."])
b.append(['p',"For a doctor, \"being found\" happens in more places than the website:"])
b.append(['ul',[
 "<strong>Google Business Profile.</strong> For many patients, this is the first thing they see. Keep the categories, hours, phone number and photos accurate, and reply to reviews.",
 "<strong>The doctor's profile pages.</strong> Hospital pages, clinic pages and medical directories should say the same thing about the doctor's name, speciality and qualifications.",
 "<strong>AI answers.</strong> Patients now ask ChatGPT and Google's AI Overviews which surgeon to see. Those tools build their answer from what they can find and match across the web."]])
b.append(['p',"That last point is where consistency matters. If the doctor's name, title and speciality differ across pages, an AI tool may get them wrong or leave them out. Structured data helps here. I explain how in "+a("Schema is your website's resume.",U+'/schema-markup-ai-visibility/')+" and how to connect a doctor's profiles in "+a('What is sameAs schema?',U+'/sameas-schema/')+"."])
b.append(['p',"If you want to be cited in AI answers, I've shared what worked for me in "+a('How to rank in AI Overviews',U+'/rank-in-ai-overviews/')+"."])
b.append(['h2','Paid media that books appointments','paid-media'])
b.append(['p',"Paid media is the fastest way to bring patients to a doctor. It's also the fastest way to waste money if the steps above aren't ready."])
b.append(['p',"The principles I follow:"])
b.append(['ul',[
 "<strong>Start with search.</strong> Someone searching for a specific procedure and a location is closer to booking than someone scrolling a social feed. Social media works well for building trust over time, but search tends to bring intent.",
 "<strong>Separate procedures.</strong> Group campaigns or ad groups by procedure, so each ad points to a page that answers questions about that procedure.",
 "<strong>Watch the search terms.</strong> Google's AI-driven matching now decides more of which searches your ads appear for. Google began automatically moving eligible Search campaigns to AI Max in September 2026, so check the search terms report regularly and exclude what doesn't fit.",
 "<strong>Bid on the right outcome.</strong> Once consultation tracking works, let bidding optimise for booked consultations, not form fills."]])
b.append(['tip','Compliance note',"Healthcare advertising in the UAE has its own rules, and they apply to ads, landing pages and social posts. Dubai Health Authority (DHA) bans absolute or exaggerated claims such as \"the best\", \"100%\", \"no side effects\" and \"immediate results\" in social media advertising, and doctors must use the name and speciality on their licence. Abu Dhabi's Department of Health and the Ministry of Health and Prevention have their own guidance. Google also has its own "+a('healthcare and medicines advertising policy','https://support.google.com/adspolicy/answer/176031')+". Check the rules that apply to your doctor's licence before you write a word of copy. Sources: "+a('DHA standards for medical advertisement content on social media','https://www.dha.gov.ae/uploads/042022/Standards%20for%20Medical%20Advertisement%20Content%20in%20Social%20Media2022433965.pdf')+", "+a('DoH standards','https://www.doh.gov.ae/en/resources/standards')+"."])
b.append(['h2','Where this plan breaks','limits'])
b.append(['p',"I want to be honest about what this plan doesn't do."])
b.append(['ul',[
 "<strong>It can't replace reputation.</strong> Many patients choose a surgeon because a friend recommended them. Marketing can support word of mouth, but it can't create it.",
 "<strong>Insurance and pricing decide a lot.</strong> If a procedure isn't covered, or the price is far from what patients expect, a better page won't fix that.",
 "<strong>Capacity is a ceiling.</strong> If the doctor's diary is already full for weeks, more enquiries mean longer waits and more patients going elsewhere.",
 "<strong>Small budgets limit tracking.</strong> A clinic with very few enquiries a month will struggle to give Google enough consultations to optimise for. In that case, track consultations anyway, and judge campaigns by hand.",
 "<strong>Rules can change.</strong> Regulators update their guidance. What was fine last year may not be fine now."]])
b.append(['tip','Bonus Tip: be your own mystery patient',"Once a month, book a consultation the way a patient would. Search for the procedure, click through, and send a WhatsApp at 10pm. Write down every moment you felt unsure or had to wait. That list is your marketing plan for next month."])
b.append(['note','What to do on Monday','ul',[
 "Call, WhatsApp and fill in the form on your doctor's website, and time each response.",
 "Read the landing page as a nervous patient and list the questions it doesn't answer.",
 "Check what your ad campaigns are optimising for. If it isn't booked consultations, plan the change.",
 "Start a shared sheet where the front desk marks each enquiry as booked, attended or not interested.",
 "Search the doctor's name in Google and ChatGPT, and note anything that's wrong or missing."]])
b.append(['h2','Frequently asked questions','faq'])
faq=[("Can doctors advertise on social media in Dubai?","Yes, but within the Dubai Health Authority's standards for medical advertising on social media. Doctors and clinics can't use absolute or exaggerated claims such as \"the best\" or \"no side effects\", can't claim to be better than other doctors, and must use the name and speciality on their licence. Patient photos or videos need documented written consent."),
("What's the fastest way for a new doctor to get appointments?","Fix the booking path first, then run search ads for the doctor's main procedures in their area. Search brings people who are already looking. Make sure the landing page explains who the doctor is and what the consultation involves, and that someone replies to every enquiry quickly, including on WhatsApp."),
("Does a doctor need their own website, or is a hospital profile page enough?","A hospital or clinic profile page can be enough if it's complete, accurate and easy to book from. A separate website helps when the doctor has their own practice or a specialist focus. Either way, the doctor's name, title and speciality should match across every page, so search engines and AI tools describe them correctly."),
("How do I track appointments from Google Ads?","Record every enquiry with its source, have the front desk mark which ones booked and attended, and send those outcomes back to Google Ads. Enhanced conversions for leads does this by matching hashed contact details to ad clicks. Once enough data is flowing, make booked consultations the conversion your campaigns optimise for."),
("Should a doctor start with Google Ads or social media?","For appointments, I usually start with Google search, because people searching for a procedure near them are closer to booking. Social media is better for building familiarity and trust over time. Most doctors benefit from both, but search tends to pay back sooner, as long as the landing page and booking path are ready.")]
for q,ans in faq:
    b.append(['h3s',q]); b.append(['p',ans])
b.append(['cta',"What's the one step on the Appointment Path where your patients drop off?","If you try this plan, or if it doesn't work the way I described, write to me. I'd genuinely love to hear how it goes.","Get in touch &rarr;",U+'/contact/'])
fills=json.load(open(sys.argv[1])) if len(sys.argv)>1 else {}
s=json.dumps(b,ensure_ascii=False)
for k,v in fills.items(): s=s.replace('{{'+k+'}}',v.replace('"','\\"'))
out=json.loads(s)
json.dump(out,open(sys.argv[2] if len(sys.argv)>2 else '/dev/stdout','w'),ensure_ascii=False)
import re; print('blocks',len(out),'placeholders left',sorted(set(re.findall(r'\{\{C\d\}\}',s))),file=sys.stderr)
