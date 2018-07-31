<main id="main-content" class="main-content">
    <section id="help-sidebar" class="help-sidebar">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <div class="side" id="side">
                        <ul>
                            <?php
                                $query = $this->db->query('SELECT * FROM support')->result();
                                foreach ($query AS $support) {
                            ?>
                            <li>
                                <a href="<?php echo base_url().'help/'.$support->support_sess.'/'.url_title(strtolower($support->support_title));?>" class="<?php echo $this->uri->segment(2)==$support->support_sess ? 'is_active' : '';?>"><?php echo $support->support_title;?></a>
                            </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>

                <div class="col-md-9">
                    <div class="box">
                        <div class="title">
                            <h3><?php echo $get->support_title;?></h3>
                        </div>

                        <div class="help-content">
                            <p><?php echo $get->support_content;?></p>
                        </div>
                    </div>
                
                </div>
            </div>
        </div>

    </section>
</main>