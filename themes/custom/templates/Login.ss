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
                                type="text"
                                class="form-control"
                                name="email"
                                id="MemberLoginForm_LoginForm_Email"
                                autofocus="true"
                                required="required"
                                aria-required="true"
                            />
                            <label class="floating-label">Email</label>
                        </div>
                        <div
                            class="form-group form-material floating"
                            data-plugin="formMaterial"
                        >
                            <input
                                type="password"
                                name="password"
                                class="form-control"
                                id="MemberLoginForm_LoginForm_Password"
                                required="required"
                                aria-required="true"
                                autocomplete="off"
                            />
                            <label class="floating-label">Password</label>
                        </div>
                        <div class="form-group clearfix">
                            <div
                                class="checkbox-custom checkbox-inline checkbox-primary checkbox-lg float-left"
                            >
                                <input
                                    type="checkbox"
                                    id="inputCheckbox"
                                    name="remember"
                                />
                                <label for="inputCheckbox">Remember me</label>
                            </div>
                            <a class="float-right" href="forgot-password.html"
                                >Forgot password?</a
                            >
                        </div>
                        <button
                            type="submit"
                            value="Login"
                            class="btn btn-primary btn-block btn-lg mt-40 bg-purchasing"
                        >
                            Sign in
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
                            value="21bc085983c44798ad1a6e6d289f0f76cbb89102"
                            class="hidden code"
                        />
                    </form>
                </fieldset>
                <p>
                    Still no account? Please go to
                    <a href="register-v3.html">Sign up</a>
                </p>
            </div>
        </div>
    </div>
	<!-- <footer class="page-copyright page-copyright-inverse">
		<p>WEBSITE BY Creation Studio</p>
		<p>© 2018. All RIGHT RESERVED.</p>
		<div class="social">
			<a class="btn btn-icon btn-pure" href="javascript:void(0)">
				<i class="icon bd-twitter" aria-hidden="true"></i>
			</a>
			<a class="btn btn-icon btn-pure" href="javascript:void(0)">
				<i class="icon bd-facebook" aria-hidden="true"></i>
			</a>
			<a class="btn btn-icon btn-pure" href="javascript:void(0)">
				<i class="icon bd-google-plus" aria-hidden="true"></i>
			</a>
		</div>
	</footer> -->
</div>
<% include FootLogin %>
</body>
</html>

