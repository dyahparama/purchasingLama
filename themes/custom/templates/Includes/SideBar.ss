<div class="site-menubar">
	<div class="site-menubar-body">
	  <div>
		<div>
		  <ul class="site-menu" data-plugin="menu">
			<li class="site-menu-category">Welcome {$getUsername()}</li>
			<!-- <li class="site-menu-item">
			  	<a class="animsition-link" href="#">
					<i class="site-menu-icon md-view-dashboard" aria-hidden="true"></i> -->
					<!-- <i class="" aria-hidden="true"></i> -->
					<!-- <span class="site-menu-title">Dashboard</span>
				</a>
			</li> -->
			<!-- <li class="site-menu-item has-sub<% if $siteParent == 'Welcome' %> active open<% end_if %>">
			  <a href="javascript:void(0)">
					<i class="" aria-hidden="true"></i>
				  	<span class="site-menu-title">Welcome Nandi</span>
					<span class="site-menu-arrow"></span><br>
				  </a>
			  <ul class="site-menu-sub">
				<li class="site-menu-item <% if $siteChild == 'Profil' %> active<% end_if %>">
				  <a class="animsition-link" href="/prfl">
					<span class="site-menu-title">Profil</span>
				  </a>
				</li>
			  </ul>
			</li> -->
			<li class="site-menu-item<% if $siteParent == 'My Task' %> active open<% end_if %>">
				<a class="animsition-link" href="{$BaseHref}ta">
                  	<i class="" aria-hidden="true"></i>
					<span class="site-menu-title">My task <% if $total %>($total)<% end_if %></span>
				</a>
			</li>
			<li class="site-menu-item has-sub<% if $siteParent == 'Draft RB' %> active open<% end_if %>">
			  <a href="javascript:void(0)">
					<i class="" aria-hidden="true"></i>
				  	<span class="site-menu-title">Draft RB</span>
					<span class="site-menu-arrow"></span><br>
				  </a>
			  <ul class="site-menu-sub">
				<li class="site-menu-item<% if $siteChild == 'Me' %> active<% end_if %>">
				  <a class="animsition-link" href="{$BaseHref}list-rb/Me">
					<span class="site-menu-title">Me</span>
				  </a>
				</li>
				<li class="site-menu-item<% if $siteChild == 'Team' %> active<% end_if %>">
				  <a class="animsition-link" href="{$BaseHref}list-rb/Teams">
					<span class="site-menu-title">Team</span>
				  </a>
				</li>
			  </ul>
			</li>
			<li class="site-menu-item has-sub<% if $siteParent == 'RB' %> active open<% end_if %>">
				<a href="javascript:void(0)">
					  <i class="" aria-hidden="true"></i>
						<span class="site-menu-title">RB</span>
					  <span class="site-menu-arrow"></span><br>
					</a>
				<ul class="site-menu-sub">
				  <li class="site-menu-item<% if $siteChild == 'RB Me' %> active<% end_if %>">
					<a class="animsition-link" href="{$BaseHref}rb">
					  <span class="site-menu-title">Me</span>
					</a>
				  </li>
				  <li class="site-menu-item<% if $siteChild == 'RB Team' %> active<% end_if %>">
					<a class="animsition-link" href="{$BaseHref}rb">
					  <span class="site-menu-title">Team</span>
					</a>
				  </li>
				</ul>
			  </li>
			<li class="site-menu-item<% if $siteParent == 'PO' %> active open<% end_if %>">
				<a class="animsition-link" href="{$BaseHref}po/PoList">
					<i class="" aria-hidden="true"></i>
					<span class="site-menu-title">PO</span>
				</a>
			</li>
			<li class="site-menu-item<% if $siteParent == 'LPB' %> active open<% end_if %>">
				<a class="animsition-link" href="#">
					<i class="" aria-hidden="true"></i>
					<span class="site-menu-title">LPB</span>
				</a>
			</li>
			<li class="site-menu-item has-sub<% if $siteParent == 'Reject' %> active open<% end_if %>">
			  <a href="javascript:void(0)">
					<i class="" aria-hidden="true"></i>
				  	<span class="site-menu-title">Transaksi yang di Reject</span>
					<span class="site-menu-arrow"></span><br>
				  </a>
			  <ul class="site-menu-sub<% if $siteChild == 'Me Reject' %> active<% end_if %>">
				<li class="site-menu-item">
				  <a class="animsition-link" href="{$BaseHref}rj/rjme">
					<span class="site-menu-title">Me</span>
				  </a>
				</li>
				<li class="site-menu-item<% if $siteChild == 'Team Reject' %> active<% end_if %>">
				  <a class="animsition-link" href="{$BaseHref}rj/rjteam">
					<span class="site-menu-title">Team</span>
				  </a>
				</li>
			  </ul>
			</li>
		  </ul>
<!-- 		  <div class="site-menubar-section">
			<h5>
			  Milestone
			  <span class="float-right">30%</span>
			</h5>
			<div class="progress progress-xs">
			  <div class="progress-bar active" style="width: 30%;" role="progressbar"></div>
			</div>
			<h5>
			  Release
			  <span class="float-right">60%</span>
			</h5>
			<div class="progress progress-xs">
			  <div class="progress-bar progress-bar-warning" style="width: 60%;" role="progressbar"></div>
			</div>
		  </div> -->
		</div>
	  </div>
	</div>
  
	<div class="site-menubar-footer">
	  <a href="javascript: void(0);" class="fold-show" data-placement="top" data-toggle="tooltip"
		data-original-title="Settings">
		<span class="icon md-settings" aria-hidden="true"></span>
	  </a>
	  <a href="javascript: void(0);" data-placement="top" data-toggle="tooltip" data-original-title="Lock">
		<span class="icon md-eye-off" aria-hidden="true"></span>
	  </a>
	  <a href="javascript: void(0);" data-placement="top" data-toggle="tooltip" data-original-title="Logout">
		<span class="icon md-power" aria-hidden="true"></span>
	  </a>
	</div>
  </div>

  <div class="site-gridmenu">
	<div>
	  <div>
		<ul>
		  <li>
			<a href="apps/mailbox/mailbox.html">
			  <i class="icon md-email"></i>
			  <span>Mailbox</span>
			</a>
		  </li>
		  <li>
			<a href="apps/calendar/calendar.html">
			  <i class="icon md-calendar"></i>
			  <span>Calendar</span>
			</a>
		  </li>
		  <li>
			<a href="apps/contacts/contacts.html">
			  <i class="icon md-account"></i>
			  <span>Contacts</span>
			</a>
		  </li>
		  <li>
			<a href="apps/media/overview.html">
			  <i class="icon md-videocam"></i>
			  <span>Media</span>
			</a>
		  </li>
		  <li>
			<a href="apps/documents/categories.html">
			  <i class="icon md-receipt"></i>
			  <span>Documents</span>
			</a>
		  </li>
		  <li>
			<a href="apps/projects/projects.html">
			  <i class="icon md-image"></i>
			  <span>Project</span>
			</a>
		  </li>
		  <li>
			<a href="apps/forum/forum.html">
			  <i class="icon md-comments"></i>
			  <span>Forum</span>
			</a>
		  </li>
		  <li>
			<a href="index.html">
			  <i class="icon md-view-dashboard"></i>
			  <span>Dashboard</span>
			</a>
		  </li>
		</ul>
	  </div>
	</div>
  </div>