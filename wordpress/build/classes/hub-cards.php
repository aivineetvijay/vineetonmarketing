<?php
/**
 * Global classes for the llms.txt hub's generator cards (icon tile, status pill, name, audience, link).
 * Created through Elementor's manage-classes ability; every declaration maps to a native v4 style prop.
 * The card name, audience text and status dot/label reuse the AI Tools card classes (tcard-name, tcard-use,
 * status-dot, status-dot-soon, status-label).
 */
$vv_hub_classes = array(
	'gen-grid'      => 'display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; padding: 0px; @media(--tablet){ grid-template-columns: repeat(2, 1fr); } @media(--mobile){ grid-template-columns: 1fr; gap: 16px; }',
	'gen-card'      => 'display: flex; flex-direction: column; gap: 20px; min-width: 0px; padding: 28px; background-color: var(--color-canvas); border-width: 1px; border-style: solid; border-color: var(--color-hairline); border-radius: 18px; &:hover { border-color: var(--color-ink); } @media(--mobile){ padding: 24px; }',
	'gen-card-soon' => 'display: flex; flex-direction: column; gap: 20px; min-width: 0px; padding: 28px; background-color: var(--color-surface-pearl); border-width: 1px; border-style: dashed; border-color: var(--color-surface-chip-translucent); border-radius: 18px; @media(--mobile){ padding: 24px; }',
	'gen-top'       => 'display: flex; flex-direction: row; justify-content: space-between; align-items: center; gap: 12px; padding: 0px;',
	'gen-icon-tile' => 'flex-shrink: 0; display: flex; align-items: center; justify-content: center; width: 52px; height: 52px; padding: 0px; border-radius: 14px; background-color: var(--color-canvas-parchment);',
	'gen-icon'      => 'width: 26px; height: 26px; max-width: 26px; max-height: 26px; display: flex;',
	'gen-pill'      => 'width: auto; flex-shrink: 0; display: flex; flex-direction: row; align-items: center; gap: 6px; padding: 5px 10px 5px 10px; border-width: 1px; border-style: solid; border-color: var(--color-hairline); border-radius: 999px;',
	'gen-body'      => 'display: flex; flex-direction: column; gap: 10px; flex-grow: 1; padding: 0px;',
	'gen-cta'       => 'font-family: var(--font-text); font-size: 15px; font-weight: 500; color: var(--color-primary); line-height: 1.4;',
	'gen-cta-soon'  => 'font-family: var(--font-text); font-size: 15px; font-weight: 500; color: var(--color-ink-muted-48); line-height: 1.4;',
);
