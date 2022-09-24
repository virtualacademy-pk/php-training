<?php
include 'contacts.php';
function add_customer($data)
{


    add_contact(1, $data);

}

function update_customer($data)
{
     update_contact(1, $data);

}

function get_customers()
{

        echo json_encode(get_contact_data(1));

}

function get_customer($id)
{
    echo json_encode(get_contact(1, $id));
}

function filter_customer($name)
{

        echo json_encode(filter_contact(1, $name));

}


function delete_customer($id)
{
    echo  delete_contact(1, $id);

}

?>