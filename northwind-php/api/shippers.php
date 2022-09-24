<?php
include 'contacts.php';
function add_shipper($data)
{


    add_contact(2, $data);

}

function update_shipper($data)
{
     update_contact(2, $data);

}

function get_shippers()
{

        echo json_encode(get_contact_data(2));

}

function get_shipper($id)
{
    echo json_encode(get_contact(2, $id));
}

function filter_shipper($name)
{

        echo json_encode(filter_contact(2, $name));

}


function delete_shipper($id)
{
    echo  delete_contact(2, $id);

}

?>