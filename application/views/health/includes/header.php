
<nav class="navbar navbar-transparent navbar-absolute">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <h4><a class="navbar-brand" href="<?= base_url('Health/profile');?>"><b> <span style="margin-left:30px;"><?= $_SESSION['user']['user_name'];?></span></b></a> </h4>
                    </div>
                    <div class="collapse navbar-collapse">
                        <ul class="nav navbar-nav navbar-right">
                             
                             <li>
                                <a href="<?= base_url('logout');?>" >
                                    <i class="fa fa-sign-out"></i>
                                </a>
                            </li>
                             
                            
                        </ul>
                         <form class="navbar-form navbar-right" role="search"  action="<?= base_url('Health/searchmydoc');?>">
                            <div class="form-group  is-empty">
                                <input type="text" class="form-control" name="search" minlength="3" required placeholder="Search Your Doctors">
                                <span class="material-input"></span>
                            </div>
                            <button type="submit" class="btn btn-white btn-round btn-just-icon">
                                <i class="material-icons">search</i>
                                <div class="ripple-container"></div>
                            </button>
                        </form>
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
                                <b> Warning - </b> Your account is not active yet. Please provide all the basic details to make your account active."</span>
                            </div>
                         </div>
                    <?php
                }
            ?>