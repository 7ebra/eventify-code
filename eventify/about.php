<?php
$pageTitle = 'Journal';
require 'includes/auth.php';
include 'includes/header.php';
?>

<section class="page-head">
    <div class="wrap">
        <span class="eyebrow">Section IV · The Journal</span>
        <h1>A note from the <em class="italic-display">editor</em></h1>
        <p>On gatherings, code, and the small art of paying attention.</p>
    </div>
</section>

<section class="section-pad">
    <div class="wrap narrow">
        <article style="font-size: 1.1rem; line-height: 1.85; color: var(--ink-soft);">
            <p style="font-family: var(--font-display); font-size: 1.5rem; font-style: italic; color: var(--ink); margin-bottom: 2rem; line-height: 1.4;">
                "The most interesting thing about a city is not its buildings, but the small,
                temporary occasions that fill them — and the people they bring together."
            </p>
            
            <p>
                Eventify began as a quiet protest against the noise of social media event listings
                — those endless scrolls of garish posters, frantic typography, and exclamation marks
                begging for attention. We thought: what if a directory of public events read like a
                proper journal? Set with care. Photographed honestly. Indexed without urgency.
            </p>
            
            <p>
                The result is what you see. A single voice for a thousand happenings, designed
                so that a chamber recital and a backyard pizza night might sit equally on the page.
            </p>
            
            <hr class="rule">
            
            <h2 style="font-size: 1.5rem; margin-bottom: 1rem;">On the making</h2>
            <p>
                Every page here is hand-written — no frameworks, no page builders, no templates
                lifted from elsewhere. The frontend leans on semantic HTML, restrained CSS, and
                vanilla JavaScript. The backend is PHP and MySQL, with passwords properly hashed
                and queries properly prepared. It is, deliberately, a small thing.
            </p>
            
            <h2 style="font-size: 1.5rem; margin: 2rem 0 1rem;">On the typography</h2>
            <p>
                Headlines are set in <em>Fraunces</em>, a contemporary serif with the soul of
                a 19th-century specimen. Body copy uses <em>EB Garamond</em>, a faithful revival
                of Claude Garamond's Renaissance romans. Flourishes appear in <em>Italiana</em>,
                a single-weight script of unusual restraint.
            </p>
            
            <h2 style="font-size: 1.5rem; margin: 2rem 0 1rem;">On the developer</h2>
            <p>
                This was built as part of a coursework project, but I tried to make it the way
                I'd make a real product — considering not just what the brief required, but how
                the cursor moves, how the page feels at rest, what it sounds like when you click.
                Software, like a good magazine, deserves quiet attention to its details.
            </p>
            
            <hr class="rule">
            
            <p style="text-align: right; font-family: var(--font-script); font-size: 1.5rem; color: var(--brass); margin-top: 2rem;">
                — The Editor
            </p>
        </article>
    </div>
</section>

<?php include 'includes/footer.php'; ?>