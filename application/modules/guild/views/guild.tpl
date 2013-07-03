{if !$guild}
	<div style="padding:10px;text-align:center;">The requested guild does not exist</div>
{else}
<section id="guild_top">

	<section id="guild_info">
		{if $guild.motd}
			"{nl2br($guild.motd)}"
		{else}
			This guild has no message of the day.
		{/if}
	</section>

	<section id="guild_name">
		<h1>{$guild.guildName}</h1>
		<h2><b>{count($members)}</b> members, <i>{$realmName}</i></h2>
	</section>

	<div class="clear"></div>
</section>

<div class="ucp_divider"></div>

	<div class="search_result_character">
		<a href="{$url}character/{$realmId}/{$leader.guid}"><img width="54" height="54" src="{$url}application/images/avatars/{$leader.avatar}.gif" class="avatar"/></a>
		<a class="color-c{$leader.race} name" href="{$url}character/{$realmId}/{$leader.guid}">{$leader.name}</a>
		<span>
			<b>{$leader.level}</b> {$leader.raceName} {$leader.className}<br />
			Leader
		</span>
	</div>

	{if $members}
		{foreach from=$members item=character}
			{if $character.guid != $guild.leaderguid}
				<div class="search_result_character">
					<a href="{$url}character/{$realmId}/{$character.guid}"><img width="54" height="54" src="{$url}application/images/avatars/{$character.avatar}.gif" class="avatar"/></a>
					<a class="color-c{$character.race} name" href="{$url}character/{$realmId}/{$character.guid}">{$character.name}</a>
					<span>
						<b>{$character.level}</b> {$character.raceName} {$character.className}<br />
						{$character.rname}
					</span>
				</div>
			{/if}
		{/foreach}
	{/if}

	<div class="clear"></div>
{/if}