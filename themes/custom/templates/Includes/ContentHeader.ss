<div class="page-header">
	<h1 class="page-title">$PageTitle</h1>
	<ol class="breadcrumb">
	  <li class="breadcrumb-item"><a href="/">Home</a></li>
	  <li class="breadcrumb-item active">$PageTitle</li>
	</ol>
	<% if $linkNew %>
	<div class="page-header-actions">
	  <a href="{$BaseHref}{$linkNew}" type="button" class="btn btn-sm btn-icon btn-primary btn-round" data-toggle="tooltip"
		data-original-title="New">
		<i class="icon md-edit" aria-hidden="true"></i>
	</a>
	  <!-- <button type="button" class="btn btn-sm btn-icon btn-primary btn-round" data-toggle="tooltip"
		data-original-title="Refresh">
		<i class="icon md-refresh-alt" aria-hidden="true"></i>
	  </button>
	  <button type="button" class="btn btn-sm btn-icon btn-primary btn-round" data-toggle="tooltip"
		data-original-title="Setting">
		<i class="icon md-settings" aria-hidden="true"></i>
	  </button> -->
	</div>
	<% end_if %>
  </div>