<?php
/**
 * Global classes for the long-form essay blocks (summary box, contents list, code sample,
 * tables, framework box, action box, closing call to action). Created through Elementor's
 * own manage-classes ability; every declaration maps to a native v4 style prop.
 * Each class is standalone (never stacked on another class it would have to override).
 */
$vv_essay_classes = array(
	'art-sub'           => 'font-family: var(--font-display); font-weight: 600; font-size: 22px; color: var(--color-ink); letter-spacing: -0.015em; line-height: 1.25; margin: 16px 0px 0px 0px; @media(--mobile){ font-size: 20px; }',
	'art-box'           => 'display: flex; flex-direction: column; gap: 14px; padding: 20px 0px 20px 0px; border-width: 2px 0px 1px 0px; border-style: solid; border-color: var(--color-ink);',
	'art-p-sm'          => 'font-family: var(--font-text); font-size: 17px; color: var(--color-ink-muted-80); letter-spacing: -0.01em; line-height: 1.6; @media(--mobile){ font-size: 16px; }',
	'sm-mark'           => 'font-family: var(--font-text); font-size: 14px; color: var(--color-ink-muted-48); line-height: 27px; min-width: 18px; flex: 0 0 auto; @media(--mobile){ line-height: 25.6px; }',
	'art-toc'           => 'display: flex; flex-direction: column; gap: 10px; padding: 4px 0px 4px 20px; border-width: 0px 0px 0px 3px; border-style: solid; border-color: var(--color-ink);',
	'toc-mark'          => 'font-family: var(--font-text); font-size: 14px; color: var(--color-ink-muted-48); line-height: 23px; min-width: 18px; flex: 0 0 auto;',
	'art-toc-link'      => 'font-family: var(--font-text); font-size: 16px; color: var(--color-primary); text-decoration: underline; line-height: 1.45; &:hover { color: var(--color-primary-focus); } @media(--mobile){ font-size: 15px; }',
	'art-code'          => 'font-family: Roboto Mono; font-size: 13px; line-height: 1.6; color: var(--color-ink); background: var(--color-canvas-parchment); border-radius: 10px; padding: 16px 18px 16px 18px; overflow: auto;',
	'art-table'         => 'display: flex; flex-direction: column; width: 100%; padding: 0px;',
	'art-thr'           => 'display: grid; grid-template-columns: 1fr 1fr; column-gap: 20px; padding: 10px 0px 10px 0px; border-width: 0px 0px 2px 0px; border-style: solid; border-color: var(--color-ink); @media(--mobile){ column-gap: 14px; }',
	'art-tr'            => 'display: grid; grid-template-columns: 1fr 1fr; column-gap: 20px; padding: 12px 0px 12px 0px; border-width: 0px 0px 1px 0px; border-style: solid; border-color: var(--color-hairline); @media(--mobile){ column-gap: 14px; }',
	'art-thr-4'         => 'display: grid; grid-template-columns: 0.8fr 1.3fr 1.1fr 1.1fr; column-gap: 20px; padding: 10px 0px 10px 0px; border-width: 0px 0px 2px 0px; border-style: solid; border-color: var(--color-ink); @media(--mobile){ display: none; }',
	'art-tr-4'          => 'display: grid; grid-template-columns: 0.8fr 1.3fr 1.1fr 1.1fr; column-gap: 20px; padding: 12px 0px 12px 0px; border-width: 0px 0px 1px 0px; border-style: solid; border-color: var(--color-hairline); @media(--mobile){ grid-template-columns: 1fr; gap: 10px; padding: 16px 0px 16px 0px; }',
	'art-th'            => 'font-family: var(--font-text); font-size: 15px; font-weight: 600; color: var(--color-ink); line-height: 1.4; @media(--mobile){ font-size: 14px; }',
	'art-td'            => 'font-family: var(--font-text); font-size: 15px; color: var(--color-ink-muted-80); line-height: 1.5; @media(--mobile){ font-size: 14px; }',
	'art-cell'          => 'display: flex; flex-direction: column; gap: 4px; padding: 0px;',
	'art-td-label'      => 'display: none; font-family: var(--font-text); font-size: 11px; color: var(--color-ink-muted-48); letter-spacing: 0.1em; text-transform: uppercase; line-height: 1.3; @media(--mobile){ display: block; }',
	'art-callout'       => 'display: flex; flex-direction: column; gap: 12px; padding: 22px 24px 22px 24px; border-width: 1px; border-style: solid; border-color: var(--color-hairline); border-radius: 12px; @media(--mobile){ padding: 18px 18px 18px 18px; }',
	'art-note'          => 'display: flex; flex-direction: column; gap: 12px; padding: 20px 24px 20px 24px; background: var(--color-canvas-parchment); border-radius: 12px; @media(--mobile){ padding: 18px 18px 18px 18px; }',
	'art-callout-title' => 'font-family: var(--font-display); font-size: 20px; font-weight: 700; color: var(--color-ink); letter-spacing: -0.01em; line-height: 1.3; @media(--mobile){ font-size: 18px; }',
	/* Essay FAQ accordion: sized to the article text (the Contact page keeps the larger acc-head/acc-title). */
	'art-acc-head'      => 'display: flex; flex-direction: row; justify-content: space-between; align-items: center; gap: 20px; padding: 20px 0px 20px 0px; @media(--mobile){ gap: 12px; padding: 16px 0px 16px 0px; }',
	'art-acc-title'     => 'font-family: var(--font-display); font-weight: 600; font-size: 20px; color: var(--color-ink); letter-spacing: -0.01em; line-height: 1.35; margin: 0px; @media(--mobile){ font-size: 17px; }',
	/* Accordion chevron (shared with Contact): Elementor's base .e-svg-base sets height: 100%, which stretched
	   the 14x9 chevron to the icon box. max-height/max-width hold the designed size; the icon box centres it. */
	'acc-icon'          => 'width: 28px; height: 28px; color: var(--color-ink); flex: 0 0 28px; display: flex; flex-direction: row; align-items: center; justify-content: center; @media(--mobile){ width: 24px; height: 24px; flex: 0 0 24px; }',
	'acc-chevron'       => 'width: 14px; height: 9px; max-width: 14px; max-height: 9px; display: flex;',
	/* Essay banners with their own art direction: a wide 3:1 image on desktop/tablet, a 16:10 crop on mobile. */
	'art-banner-desktop' => 'display: block; width: 100%; max-width: 100%; height: auto; aspect-ratio: 3 / 1; object-fit: cover; border-radius: 12px; margin: 0px 0px 56px 0px; @media(--mobile){ display: none; }',
	'art-banner-mobile'  => 'display: none; width: 100%; max-width: 100%; height: auto; aspect-ratio: 16 / 10; object-fit: cover; border-radius: 12px; margin: 0px 0px 40px 0px; @media(--mobile){ display: block; }',
	/* Diagram box: two columns (stepped hierarchy + supporting boxes) that wrap to one column on narrow screens. */
	'dg-cols'           => 'display: flex; flex-direction: row; flex-wrap: wrap; gap: 24px; padding: 0px;',
	'dg-col'            => 'display: flex; flex-direction: column; flex: 1 1 260px; min-width: 0px; padding: 0px;',
	'dg-label'          => 'font-family: var(--font-text); font-size: 12px; color: var(--color-ink-muted-48); letter-spacing: 0.1em; text-transform: uppercase; line-height: 1.2; margin: 0px 0px 10px 0px;',
	'dg-box'            => 'display: flex; flex-direction: column; gap: 2px; padding: 10px 14px 10px 14px; border-width: 2px; border-style: solid; border-color: var(--color-ink); border-radius: 10px;',
	'dg-box-dashed'     => 'display: flex; flex-direction: column; gap: 2px; padding: 10px 14px 10px 14px; margin: 0px 0px 10px 0px; border-width: 1px; border-style: dashed; border-color: var(--color-ink-muted-48); border-radius: 10px;',
	'dg-box-title'      => 'font-family: var(--font-text); font-size: 16px; font-weight: 600; color: var(--color-ink); line-height: 1.35;',
	'dg-box-sub'        => 'font-family: var(--font-text); font-size: 14px; color: var(--color-ink-muted-80); line-height: 1.4;',
	'dg-arrow'          => 'font-family: var(--font-text); font-size: 14px; color: var(--color-ink-muted-48); line-height: 1; padding: 4px 0px 4px 12px;',
	'dg-indent-1'       => 'margin: 0px 0px 0px 24px; @media(--mobile){ margin: 0px 0px 0px 12px; }',
	'dg-indent-2'       => 'margin: 0px 0px 0px 48px; @media(--mobile){ margin: 0px 0px 0px 24px; }',
	'dg-indent-3'       => 'margin: 0px 0px 0px 72px; @media(--mobile){ margin: 0px 0px 0px 36px; }',
	/* Comparison box rows: coloured mark + text. */
	'cmp-row'           => 'display: flex; flex-direction: row; gap: 10px; align-items: flex-start; padding: 0px 0px 8px 0px;',
	'cmp-good'          => 'font-family: var(--font-text); font-size: 15px; font-weight: 700; color: var(--color-status-live); line-height: 1.5; min-width: 16px; flex: 0 0 auto;',
	'cmp-warn'          => 'font-family: var(--font-text); font-size: 15px; font-weight: 700; color: var(--color-status-beta); line-height: 1.5; min-width: 16px; flex: 0 0 auto;',
	'cmp-bad'           => 'font-family: var(--font-text); font-size: 15px; font-weight: 700; color: var(--color-status-bad); line-height: 1.5; min-width: 16px; flex: 0 0 auto;',
	/* In-article screenshot: full width, natural height (never cropped). */
	'art-shot'          => 'display: block; width: 100%; max-width: 100%; height: auto; border-radius: 10px; border-width: 1px; border-style: solid; border-color: var(--color-hairline);',
	'art-cta'           => 'display: flex; flex-direction: column; gap: 10px; padding: 24px 0px 0px 0px; margin: 16px 0px 0px 0px; border-width: 1px 0px 0px 0px; border-style: solid; border-color: var(--color-hairline);',
	'art-cta-link'      => 'font-family: var(--font-text); font-size: 17px; font-weight: 600; color: var(--color-primary); line-height: 1.4; &:hover { color: var(--color-primary-focus); }',
);
