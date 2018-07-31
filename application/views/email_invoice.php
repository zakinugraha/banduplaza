<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Detail invoice order</title>
    
    <style>
    .invoice-box{
        max-width:800px;
        margin:auto;
        padding:30px;
        border:1px solid #eee;
        box-shadow:0 0 10px rgba(0, 0, 0, .15);
        font-size:16px;
        line-height:24px;
        font-family:'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        color:#555;
    }
    
    span {
        font-weight: bold;
        padding: 2px 7px;
        background-color: red;
        color: #fff;
        border-radius: 4px;
    }

    h4 {
        display: block;
        font-size: 16px;
        font-weight: bold;
        margin: 5px 0;
        text-decoration: underline;
    }

    p {
        font-size: 14px;
        display: block;
        margin: 0;
    }

    p.title {
        font-size: 14px;
        font-weight: bold;
        display: block;
        margin: 10px 0 0 0;
    }

    .invoice-box table{
        width:100%;
        line-height:inherit;
        text-align:left;
    }
    
    .invoice-box table td{
        padding:5px;
        vertical-align:top;
    }
    
    .invoice-box table tr td:nth-child(2){
        text-align:right;
    }
    
    .invoice-box table tr.top table td{
        padding-bottom:20px;
    }
    
    .invoice-box table tr.top table td.title{
        font-size:45px;
        line-height:45px;
        color:#333;
    }
    
    .invoice-box table tr.information table td{
        padding-bottom:40px;
    }
    
    .invoice-box table tr.heading td{
        background:#eee;
        border-bottom:1px solid #ddd;
        font-weight:bold;
    }
    
    .invoice-box table tr.details td{
        padding-bottom:20px;
    }
    
    .invoice-box table tr.item td{
        border-bottom:1px solid #eee;
    }
    
    .invoice-box table tr.item.last td{
        border-bottom:none;
    }
    
    .invoice-box table tr.total td:nth-child(2){
        border-top:2px solid #eee;
        font-weight:bold;
    }
    
    @media only screen and (max-width: 600px) {
        .invoice-box table tr.top table td{
            width:100%;
            display:block;
            text-align:center;
        }
        
        .invoice-box table tr.information table td{
            width:100%;
            display:block;
            text-align:center;
        }
    }
    </style>
</head>

<body>
    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="2">
                    <table>
                        <tr>
                            <td class="title">
                                <img src="<?php echo base_url();?>assets/front/images/logo.png" style="width:100%; max-width:300px;">
                            </td>
                            
                            <td>
                                Invoice #: <?php echo '<strong>'.$invoice_detail->invoice_number.'</strong>';?><br>
                                Created: <?php echo full_parsing_date($invoice_detail->invoice_date_order);?><br>
                                Expired: <?php echo full_parsing_date($invoice_detail->invoice_date_expired);?><br>
                                Status: <span>Unpaid</span>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            
            <tr class="information">
                <td colspan="2">
                    <table>
                        <tr>
                            <td>
                                <?php echo $address_detail->name;?><br>
                                <?php echo $customer_detail->customer_phone;?><br>
                                <?php echo $address_detail->address;?><br>
                                <?php echo $address_city->area_name.', ';?>
                                <?php echo $address_province->area_name;?><br>
                                <?php echo $address_detail->postcode;?>
                            </td>
                            
                            <td>
                                banduplaza.com<br>
                                Komp. Margaasih Blok k1 no 4<br>
                                Bandung, Jawa Barat<br>
                                40215
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            
            <tr class="heading">
                <td>Item</td>                
                <td>Price</td>
            </tr>
            
            <?php foreach ($invoice_product AS $row) { ?>
            <tr class="item">
                <td><?php echo $row->product_name.' x '.$row->product_qty;?></td>
                <td> <?php echo 'Rp. '.number_format($row->product_price_total);?></td>
            </tr>
            <?php } ?>
            <tr class="item">
                <td>Discount</td>
                <td> <?php echo $send_discount;?></td>
            </tr>
            <tr class="item">
                <td>Shipping</td>
                <td> <?php echo 'Rp. '.number_format($invoice_detail->invoice_shipping);?></td>
            </tr>
            
            <tr class="total">
                <td></td>
                
                <td>Total: <?php echo 'Rp. '.number_format($invoice_detail->invoice_grand_total);?></td>
            </tr>
        </table>

        <p>Tiga angka terakhir adalah nomor unik untuk memudahkan dalam proses konfirmasi pembayarn. Harap memasukan sesuai dengan total harga yang tertera diatas.</p>
        <p>Harap melakukan pembayaran ke salah satu rekening dibawah ini, sesuai dengan no rekening tujuan yang telah anda pilih untuk melengkapi proses order</p>
        <br>
        <h4>No Rekening</h4>
        <?php
            $query = $this->db->query('SELECT bank_name, bank_rek, bank_an FROM bank')->result();
            foreach ($query AS $bank) {
        ?>
        <p class="title"><?php echo $bank->bank_name;?></p>
        <p>No Rek : <b><?php echo $bank->bank_rek;?></b></p>
        <p>A/N <b><?php echo $bank->bank_an;?></b></p>
        <?php } ?>
        <br>
        <p>Apabila sudah melakukan proses transfer, harap melakukan konfirmasi <a href="<?php echo base_url();?>confirm">disini</a></p>
        <p>Pengiriman barang yang sudah diorder akan dilakukan setelah transaksi kami konfirmasi.</p>
        <p>Terima kasih</p>
    </div>
</body>
</html>