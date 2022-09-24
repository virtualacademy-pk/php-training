<?php
include 'contacts.php';
function add_supplier($data)
{


    add_contact(3, $data);

}

function update_supplier($data)
{
     update_contact(3, $data);

}

function get_suppliers()
{

        echo json_encode(get_contact_data(3));

}

function get_supplier($id)
{
    echo json_encode(get_contact(3, $id));
}

function filter_supplier($name)
{

        echo json_encode(filter_contact(3, $name));

}


function delete_supplier($id)
{
    echo  delete_contact(3, $id);

}

?>