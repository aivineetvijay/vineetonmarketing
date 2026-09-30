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
	'art-toc-link'      => 'font-family: var(--font-text); font-size: 16px; color: var(--color-ink); line-height: 1.45; &:hover { color: var(--color-primary); } @media(--mobile){ font-size: 15px; }',
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
	'art-cta'           => 'display: flex; flex-direction: column; gap: 10px; padding: 24px 0px 0px 0px; margin: 16px 0px 0px 0px; border-width: 1px 0px 0px 0px; border-style: solid; border-color: var(--color-hairline);',
	'art-cta-link'      => 'font-family: var(--font-text); font-size: 17px; font-weight: 600; color: var(--color-primary); line-height: 1.4; &:hover { color: var(--color-primary-focus); }',
);
