<?php
$info = array(
		"execute" 	=> '\library\capsule\accounting\accounting::init("{view}");',
		"option"	=> array("view" => array("type" => "select", "value" => array(
																					'normal',
																					'actionbar_coa',
																					'actionbar_item',
																					'actionbar_transaction',
																					'actionbar_contact_accounting',
																					'table_coa',
																					'table_item',
																					'table_transaction',
																					'table_contact_accounting',
																					'menu_user',
																					'subject_account',
																					'form_user_account',
																					'form_createInvoice',
																					'form_invoice_controller',
																					'form_bill_controller',
																					'form_receipt_controller',
																					'form_salesreceipt_controller',
																					'form_transfer_controller',
																					'form_payment_controller',
																					'form_paybill_controller')))
		);

return $info;

?>