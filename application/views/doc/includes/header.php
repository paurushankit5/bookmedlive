
<nav class="navbar navbar-transparent navbar-absolute">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="<?= base_url('Doc/profile');?>">
                            <b>
                            <span style="margin-left:30px;">Dr. <?= $_SESSION['user']['user_name'];?>
                            <?php
                                if($_SESSION['user']['clinic_name']!='')
                                {
                                    ?> 
                                    <br>
                                    <span style="font-size:13px;margin-left:30px;">( <?= $_SESSION['user']['clinic_name']; ?> )</span>

                                    <?php
                                }
                            ?>
                            </span>
                        </b></a>
                    </div>
                    <div class="collapse navbar-collapse">
                        <ul class="nav navbar-nav navbar-right">
                             
                             <li>
                                <a href="<?= base_url('logout');?>" >
                                    <i class="fa fa-sign-out"></i>
                                </a>
                            </li>
                             
                            
                        </ul>
                        <!-- <form class="navbar-form navbar-right" role="search">
                            <div class="form-group  is-empty">
                                <input type="text" class="form-control" placeholder="Search">
                                <span class="material-input"></span>
                            </div>
                            <button type="submit" class="btn btn-white btn-round btn-just-icon">
                                <i class="material-icons">search</i>
                                <div class="ripple-container"></div>
                            </button>
                        </form> -->
                    </div>
                </div>
            </nav>
            <?php
                if($_SESSION['user']['is_active']==0){
                    ?>
                        <div class="content">
                             <div class="container-fluid">
                 
                             <div class="alert alert-warning">
                                 <span>
                                <b> Warning - </b> Your account is not active yet. Please provide all the basic details to make your account active.</span>
                            </div>
                         </div>
                    <?php
                }
            ?>
             <div class="loadingDiv" style="display:none;position:fixed;top:0px;right:0px;width:100%;height:100%;background-color:#666;background-image:url('<?= base_url('img/loading.gif');?>'); background-repeat:no-repeat;background-position:center;z-index:10000000;  opacity: 0.4;">
                    <div>
                        <h7>Please wait...</h7>
                    </div>
                </div>