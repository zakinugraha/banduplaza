<script src="<?php echo base_url();?>assets/front/plugins/tinymce/js/tinymce/tinymce.min.js"></script>
<script>
    tinymce.init({
        selector: "textarea",
        height: 100,
        menubar: false,
        toolbar: false,
        statusbar: false,
    });
</script>

<main id="main-content" class="main-content">
    <section id="address" class="address">
        <div class="container text-center">
            <div class="attention">
                <span>Mengisi alamat akan memudahkan anda dalam melengkapi proses order</span>
            </div>

            <?php echo $this->session->flashdata('message');?>
        </div>

        <div class="container ">
            <div class="form text-center box-back block">

                <form action="<?php echo base_url();?>configuration/add_address" method="POST">

                    <div class="form-group">
                        <div class="col-md-3 text-left">
                            <label>Name <span class="req">*</span></label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" name="name" class="form-control" value="<?php echo set_value('name');?>" >
                            <?php echo form_error('name', '<p class="required">', '</p>');?>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-3 text-left">
                            <label>Provinsi <span class="req">*</span></label>
                        </div>
                        <div class="col-md-9">
                            <select name="province" class="form-control" id="province_id" onchange="get_city();">
                            <option value="">-- Pilih provinsi --</option>
                                <?php foreach ($province AS $row) { ?>
                                <option value="<?php echo $row->area_api_id;?>"><?php echo $row->area_name?></option>
                                <?php } ?>
                            </select>
                            <?php echo form_error('province', '<p class="required">', '</p>');?>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-3 text-left">
                            <label>Kota <span class="req">*</span></label>
                        </div>
                        <div class="col-md-9">
                            <select name="city" class="form-control" id="city_id"></select>
                            </select>
                            <?php echo form_error('city', '<p class="required">', '</p>');?>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-3 text-left">
                            <label>Kode POS</label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" name="postcode" class="form-control" value="<?php echo set_value('title');?>" >
                            <?php echo form_error('postcode', '<p class="required">', '</p>');?>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-3 text-left">
                            <label>Alamat <span class="req">*</span></label>
                        </div>
                        <div class="col-md-9">
                            <textarea name="address" rows="3" class="form-control"><?php echo set_value('address');?> </textarea>
                            <?php echo form_error('address', '<p class="required">', '</p>');?>
                        </div>
                    </div>

                    <div class="form-group text-center">
                        <input type="submit" name="submit_add" value="Submit" class="submit">
                        <a href="<?php echo base_url();?>configuration/address" class="back">Batal</a>
                    </div>
                </form>

            </div>
        </div>

    </section>
</main>

<!-- Shipping -->
<script type="text/javascript">
    var element_city=$("#city_id");
    var element_cost=$("table.container_cost").find('tbody');
    $(function(){
    });

    function get_city()
    {
        element_city.html('');
        var province_id=$('#province_id').val();
        var jqxhr=$.ajax({
            url:'<?php echo base_url()?>checkout/get_city/'+province_id,
            type:'get',
            dataType:'json',

        });
        jqxhr.success(function(response){
            element_city.html('<option value="">Pilih Kota/Kabupaten</option>');
            $.each(response,function(index,rowArr){
                element_city.append('<option value="'+rowArr['area_api_id']+'">'+rowArr['area_name']+'</option>');
            });
        });
        jqxhr.error(function(response){
            alert('an error has occurred, please try again...');
            return false;
        });
    }
</script>