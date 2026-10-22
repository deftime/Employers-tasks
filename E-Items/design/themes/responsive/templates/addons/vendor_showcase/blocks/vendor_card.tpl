{style src="addons/vendor_showcase/styles.less"}
{script src="js/addons/vendor_showcase/popups.js"}

{if $vendor_card}
    {* {$panel_mode = $block.properties.panel_mode|default:"popup"}  *}

    <div class="vendor-showcase {if $block.properties.panel_mode === 'modal'} cm-dialog-opener cm-dialog-auto-size {/if}" data-ca-target-id="vs-modal" data-panel-mode="{$block.properties.panel_mode|escape}">
        <div class="vendor-logo">
            {if $vendor_card.logo}
                <img src="{$vendor_card.logo.src|escape}" alt="{$vendor_card.name|escape}" width="100" height="100">
            {else}
                <span class="logo-empty" aria-hidden="true">{$vendor_card.initials|escape}</span>
            {/if}
            <div class="vendor-status online"></div>
        </div>
        <div class="vendor-main">
            <div class="vendor-top">
                <span class="nickname">{$vendor_card.name|default:'<Vendor Name>'}</span>
                <div class="tags">
                    <div class="tag pro">Pro</div>
                    <div class="tag verify">Verified (KYC)</div>
                </div>
            </div>
            <div class="vendor-sub">
                <span class="main online">online now</span>
                <span class="sec">since Dec 2016</span>
                <span class="sec">response <1h</span>
            </div>
            {if $vendor_card.description}
                <div class="vendor-desc">{$vendor_card.description}</div>
            {/if}
        </div>
        <div class="vendor-stats">
            <div class="data feeds">
                <span>98%</span>
                <span>positive</span>
            </div>
            <div class="data stars">
                <span>★4.9</span>
                <span>320 reviews</span>
            </div>
            <div class="data orders">
                <span>1 240</span>
                <span>orders</span>
            </div>
        </div>
        {if $block.properties.panel_mode === 'popup'}
            {include file="addons/vendor_showcase/blocks/vendor_popup.tpl"}
        {/if}
    </div>
    {if $block.properties.panel_mode === 'modal'}
        {include file="addons/vendor_showcase/blocks/vendor_modal.tpl"}
    {/if}
{/if}
