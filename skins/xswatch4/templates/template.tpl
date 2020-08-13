				<ul class="nav navbar-nav">
				<!-- assign myStr -->
				<{assign var=myStr value="["|cat:$xoops_langcode|cat:"]"}>

				<{foreach item=menu from=$block name=m_item}>

					<{if ($xlanguage && (($menu.title|strstr:$myStr) || ($menu.image|strstr:$myStr)) || !$xlanguage)}>

						<{if $menu.hassub}>
							<{if $menu.level == 0}>
							<!-- top level item - with submenu -->

					<li class="nav-item<{if $menu.selected}> active<{/if}><{if $menu.css}> <{$menu.css}><{/if}> dropdown">
						<a class="nav-link dropdown-toggle" href="<{$menu.link}>" id="<{$a_lbl}>"
							data-toggle="dropdown" target="<{$menu.target}>" >
							<{if $menu.image}><img class="menu-image" src="<{$menu.image}>" alt="<{$menu.alt_title}>" > <{/if}>
							<{$menu.title}><b class="caret"></b>
							<{if $smarty.foreach.m_item.first}> <span class="sr-only">(current)</span><{/if}>
						</a>
						<ul class="dropdown-menu">

							<{else}>
							<!-- sub-menu item - with submenu -->

							<li class="dropdown-submenu dropdown-item">
								<a href="#" class="dropdown-toggle<{if $menu.selected}> active<{/if}><{if $menu.css}> <{$menu.css}><{/if}>"
									target="<{$menu.target}>" >
									<{if $menu.image}><img class="menu-image" src="<{$menu.image}>" alt="<{$menu.alt_title}>" > <{/if}>
									<{$menu.title}>
								</a>
								<ul class="dropdown-menu" >

							<{/if}>

						<{else}>

							<{if $menu.level == 0}>
							<!-- top level item - no submenu-->

								<li class="nav-item<{if $menu.selected}> active<{/if}><{if $menu.css}> <{$menu.css}><{/if}>">
									<a class="nav-link" href="<{$menu.link}>"
										target="<{$menu.target}>" title="<{$menu.alt_title}>" >
										<{if $menu.image}><img class="menu-image" src="<{$menu.image}>" alt="<{$menu.alt_title}>" > <{/if}>
										<{$menu.title}>
									</a>
								</li>

							<{else}>
							<!-- sub-menu item - no submenu -->

							<li>
								<a class="dropdown-item<{if $menu.selected}> active<{/if}><{if $menu.css}> <{$menu.css}><{/if}>"
									href="<{$menu.link}>"
									target="<{$menu.target}>" title="<{$menu.alt_title}>" >
									<{if $menu.image}><img class="menu-image" src="<{$menu.image}>" alt="<{$menu.alt_title}>" > <{/if}>
									<{$menu.title}>
								</a>
							</li>

								<{if $menu.cul}>
								<!-- close submenu container -->
							</ul>
						</li>
								<{/if}>

							<{/if}>

						<{/if}>

					<{else}>

						Failed to find string values for <{$myStr}> and <{$menu.title}>

					<{/if}>

				<{/foreach}>
				</ul>
