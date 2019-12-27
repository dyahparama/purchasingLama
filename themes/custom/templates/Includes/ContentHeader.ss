<div class="page-header">
	<h1 class="page-title">$PageTitle</h1>
	<!-- <ol class="breadcrumb">
	  <li class="breadcrumb-item"><a href="/">Home</a></li>
	  <li class="breadcrumb-item active">$PageTitle</li>
	</ol> -->

	<div class="page-header-actions">
		<% if $linkNew %>
	  <a href="{$BaseHref}{$linkNew}" type="button" class="btn  btn-icon btn-primary btn-round" data-toggle="tooltip"
		data-original-title="New">
		<i class="icon md-plus" aria-hidden="true"></i>
	</a>
	<% end_if %>
	<% if $linkRefresh %>
	   <a id="{$linkRefresh}" type="button" href="javascript:void(0)" class="btn btn-sm btn-icon btn-primary btn-round" data-toggle="tooltip"
		data-original-title="Clear">
		<i class="icon md-refresh-alt" aria-hidden="true"></i>
		</a>
		<% end_if %>
	 <!-- <button type="button" class="btn btn-sm btn-icon btn-primary btn-round" data-toggle="tooltip"
		data-original-title="Setting">
		<i class="icon md-settings" aria-hidden="true"></i>
	  </button> -->
	</div>

  </div>
