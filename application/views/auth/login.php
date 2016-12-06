

    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><?php echo lang('login_heading');?></h3>
                    </div>
                    <div class="panel-body">

        <div id="infoMessage"><?php echo $message;?></div>

        <?php echo form_open("auth/login");?>
                            <fieldset>
                                <div class="form-group">
                                    <?php// echo lang('login_identity_label', 'identity', 'class="form_control"');?>
                                    <?php echo form_input($identity);?>
                                </div>
                                <div class="form-group">
                                    <?php// echo lang('login_password_label', 'password');?>
                                    <?php echo form_input($password, 'class="form_control"');?>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <?php echo form_checkbox('remember', '1', FALSE, 'id="remember"') . lang('login_remember_label', 'remember');?>
                                    </label>
                                </div>
                                <?php echo form_submit('submit', lang('login_submit_btn'), 'class="btn btn-lg btn-success btn-block"');?>
                                <?php echo form_close();?>
                            </fieldset>
                        </form>


<p><a href="forgot_password"><?php echo lang('login_forgot_password');?></a></p>