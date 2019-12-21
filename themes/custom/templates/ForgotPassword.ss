<!-- Page -->
<html lang="$ContentLocale">
<% include HeadLogin %>
<body>
<div
    class="page vertical-align text-center bg-purchasing"
    data-animsition-in="fade-in"
    data-animsition-out="fade-out"
>
    <div class="page-content vertical-align-middle">
        <div class="panel">
            <div class="panel-body">
                <div class="brand">
                    <img
                        class="brand-img"
                        src="/_resources/themes/custom/assets//images/logo-colored.png"
                        alt="..."
                    />
                    <h2 class="brand-text font-size-18">Purchasing System</h2>
				</div>
                <% if Error %>
				<div class="alert dark alert-danger alert-dismissible d-none" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">×</span>
                    </button>
                    You have entered an invalid email or password
                  </div>
                  <% end_if %>
                <fieldset>
                    <form
                        id="MemberLoginForm_LoginForm"
                        action="dologin"
                        method="post"
                        enctype="application/x-www-form-urlencoded"
                    >
                        <input
                            type="hidden"
                            name="AuthenticationMethod"
                            value="SilverStripe\Security\MemberAuthenticator\MemberAuthenticator"
                            class="hidden"
                            id="MemberLoginForm_LoginForm_AuthenticationMethod"
                        />
                        <div
                            class="form-group form-material floating"
                            data-plugin="formMaterial"
                        >
                            <input
                                type="password"
                                class="form-control"
                                name="password"
                                id="MemberLoginForm_LoginForm_Email"
                                autofocus="true"
                                required="required"
                                aria-required="off"
                            />
                            <label class="floating-label">New Password</label>
                        </div>
                        <div
                            class="form-group form-material floating"
                            data-plugin="formMaterial"
                        >
                            <input
                                type="password"
                                name="repeat_password"
                                class="form-control"
                                id="MemberLoginForm_LoginForm_Password"
                                required="required"
                                aria-required="true"
                                autocomplete="off"
                            />
                            <label class="floating-label">Repeat Password</label>
                        </div>
                        <button
                            type="submit"
                            value="Change Password"
                            class="btn btn-primary btn-block btn-lg mt-40 bg-purchasing"
                        >
                            Save New Password
                        </button>
                        <input
                            type="hidden"
                            name="BackURL"
                            value="/admin/pages/"
                            class="hidden"
                            id="MemberLoginForm_LoginForm_BackURL"
                        />
                        <input
                            type="hidden"
                            name="SecurityID"
                            class="hidden code"
                        />
                    </form>
                </fieldset>
            </div>
        </div>
    </div>
</div>
<% include FootLogin %>
</body>
</html>

