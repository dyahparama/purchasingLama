<!DOCTYPE html>
<!--
>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
Simple. by Sara (saratusar.com, @saratusar) for Innovatif - an awesome Slovenia-based digital agency (innovatif.com/en)
Change it, enhance it and most importantly enjoy it!
>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
-->

<!--[if !IE]><!-->
<% if $Top.URLSegment != 'Security' %>
<html lang="$ContentLocale">
    <% include Head %>
    <body class="animsition dashboard">
        <!--[if lt IE 8]>
            <p class="browserupgrade">
                You are using an <strong>outdated</strong> browser. Please
                <a href="http://browsehappy.com/">upgrade your browser</a> to
                improve your experience.
            </p>
        <![endif]-->
        <% include TopBar %>
        <% include SideBar %>
        <!-- Page -->
        <div class="page">
            <div class="page-content container-fluid">
                $Layout
            </div>
        </div>
        <!-- End Page -->

        <% include Footer %>
        <!-- Footer -->
    </body>
</html>
<% else %>
<% include HeadLogin %>
<% include Login %>
<div style="visibility: hidden;" class="temp-form">$Layout</div>
<% include FootLogin %>
<% end_if %>
