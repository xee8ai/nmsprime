<?php

return [
/**
 * Index Page - Datatables
 */
	'SortSearchColumn'				=> 'This Column cannot be searched or ordered.',
	'PrintVisibleTable'				=> 'Prints the shown table. If the table is filtered make sure to select the \"All\" option to display everything. Loading can take a few seconds.',
	'ExportVisibleTable'			=> 'Exports the shown table. If the table is filtered make sure to select the \"All\" option to display everything. Loading can take a few seconds.',
	'ChangeVisibilityTable'			=> 'Select the columns that should be visible.',

 /**
  *	MODULE: BillingBase
  */
	//BillingBaseController
	'BillingBase_cdr_offset' 		=> "TAKE CARE: incrementing this when having data from settlement runs leads to overwritten CDRs during next run - make sure to save/rename the history!\n\nExample: Set to 1 if Call Data Records from June belong to Invoices of July, Zero if it's the same month, 2 if CDRs of January belong to Invoices of March.",
	'BillingBase_cdr_retention' 	=> 'Months that Call Data Records may/have to be kept save',
	'BillingBase_extra_charge' 		=> 'Additional mark-on to purchase price. Only when not calculated through provider!',
	'BillingBase_fluid_dates' 		=> 'Check this box if you want to add tariffs with uncertain start and/or end date. If checked two new checkboxes (Valid from fixed, Valid to fixed) will appear on Item\'s edit/create page. Check out their help messages for further explanation!',
	'BillingBase_InvoiceNrStart' 	=> 'Invoice Number Counter starts every new year with this number',
	'BillingBase_ItemTermination'	=> 'Allow Customers only to terminate booked products on last day of month',
	'BillingBase_MandateRef'		=> "A Template can be built with sql columns of contract or mandate table - possible fields: \n",
	'BillingBase_SplitSEPA'			=> 'Sepa Transfers are split to different XML-Files dependent of their transfer type',

	//CompanyController
	'Company_Management'			=> 'Comma separated list of names',
	'Company_Directorate'			=> 'Comma separated list of names',
	'Company_TransferReason'		=> 'Template from all Invoice class data field keys - Contract Number and Invoice Nr is default',

	//CostCenterController
	'CostCenter_BillingMonth'		=> 'Accounting for yearly charged items - corresponds to the month the invoices are created for. Default: 6 (June) - if not set. Please be careful to not miss any payments when changing this!',

	//ItemController
	'Item_ProductId'				=> 'All fields besides Billing Cycle have to be cleared before a type change! Otherwise items can not be saved in most cases',
	'Item_ValidFrom'				=> 'For One Time Payments the fields can be used to split payment - Only YYYY-MM is considered then!',
	'Item_ValidFromFixed'			=> 'Checked by default! Uncheck if the tariff shall stay inactive when start date is reached (e.g. if customer is waiting for a phone number porting). The tariff will not start and not be charged until you activate the checkbox. Further the start date will be incremented every day by one day after reaching the start date. Info: The date is not updated by external orders (e.g. from telephony provider).',
	'Item_ValidToFixed'				=> 'Checked by default! Uncheck if the end date is uncertain. If unchecked the tariff will not end and will be charged until you activate the checkbox. Further when the end date is reached it will be incremented every day by one day. Info: The date is not updated by external orders (e.g. from telephony provider).',
	'Item_CreditAmount'				=> 'Net Amount to be credited to Customer. Take Care: a negative amount becomes a debit!',

	//ProductController
	'Product_maturity' 				=> 'Tariff period/runtime/term. E.g. 14D (14 days), 3M (three months), 1Y (one year)',
	'Product_Name' 					=> 'For Credits it is possible to assign a Type by adding the type name to the Name of the Credit - e.g.: \'Credit Device\'',
	'Product_Number_of_Cycles' 		=> 'Take Care!: for all repeatedly payed products the price stands for every charge, for Once payed products the Price is divided by the number of cycles',
	'Product_Type'					=> 'All fields besides Billing Cycle have to be cleared before a type change! Otherwise products can not be saved in most cases',

	//SalesmanController
	'Salesman_ProductList'			=> 'Add all Product types he gets commission for - possible: ',

	// SepaMandate
	'sm_cc' 						=> 'If a cost center is assigned only products related to the same cost center will be charged of this account. Leave this field empty if all charges that can not be assigned to another SEPA-Mandate with specific cost center shall be debited of this account. Note: It is assumed that all emerging costs that can not be assigned to any SEPA-Mandate will be payed in cash!',
	'sm_recur' 						=> 'Activate if there already have been transactions of this account before the creation of this mandate. Sets the status to recurring. Note: This flag is only considered on first transaction!',

	//SepaAccountController
	'SepaAccount_InvoiceHeadline'	=> 'Replaces Headline in Invoices created for this Costcenter',
	'SepaAccount_InvoiceText'		=> 'The Text of the separate four \'Invoice Text\'-Fields is automatically chosen dependent on the total charge and SEPA Mandate and is set in the appropriate Invoice for the Customer. It is possible to use all data field keys of the Invoice Class as placeholder in the form of {fieldname} to build a kind of template. These are replaced by the actual value of the Invoice.',

	// SettlementrunController
	'settlement_verification' 		=> 'If activated it\'s not possible to repeat the Settlement Run. Customer Invoices are only visible when this checkbox is activated.',

 /**
  *	MODULE: HfcReq
  */
	'netelementtype_reload' 		=> 'In Seconds. Zero to deactivate autoreload. Decimals possible.',
	'netelementtype_time_offset' 	=> 'In Seconds. Decimals possible.',
	'undeleteables' 				=> 'Net & Cluster can not be changed due to there relevance for all the Entity Relation Diagrams',

 /**
  *	MODULE: HfcSnmp
  */
	'mib_filename' 					=> 'The Filename is composed by MIB name & Revision. If there is already an existent identical File it\'s not possible to create it again.',
	'oid_link' 						=> 'Go to OID Settings',
	'oid_table' 					=> 'INFO: This Parameter belongs to a Table-OID. If you add/specify SubOIDs or/and indices, only these are considered for the snmpwalk. Besides the better Overview this can dramatically speed up the Creation of the Controlling View for the corresponding NetElement.',
	'parameter_3rd_dimension' 		=> 'Check this box if this Parameter belongs to an extra Controlling View behind an Element of the SnmpTable.',
	'parameter_diff' 				=> 'Check this if only the Difference of actual to last queried values shall be shown.',
	'parameter_divide_by' 			=> 'Make this ParameterValue percentual compared to the added values of the following OIDs that are queried by the actual snmpwalk, too. In a first step this only works on SubOIDs of exactly specified tables! The Calculation is also done after the Difference is calculated in case of Difference-Parameters.',
	'parameter_indices' 			=> 'Specify a comma separated List of all Table Rows we want the Snmp Values for.',
	'parameter_html_frame' 			=> 'Assign this parameter to a specific frame (part of the page). Doesn\'t have influences on SubOIDs in Tables (but on 3rd Dimensional Params!).',
	'parameter_html_id' 			=> 'By adding an ID you can order this parameter in sequence to other parameters. In tables you can change the column order by setting the Sub-Params html id.',

 /**
  *	MODULE: ProvBase
  */
	//ModemController
	'Modem_NetworkAccess'			=> 'Network Access for CPEs. (MTAs are not considered and will always go online when all other configurations are correct). Take care: With Billing-Module this checkbox will be overwritten by daily check if tariff changes.',
	'Modem_InstallationAddressChangeDate'	=> 'In case of (physical) relocation of the modem: Add startdate for the new address here. If readonly there is a pending address change order at Envia.',
	'contract_number' 				=> 'Attention - Customer login password is changed automatically on changing this field!',
	'mac_formats'					=> "Allowed formats (case-insensitive):\n\n1) AA:BB:CC:DD:EE:FF\n2) AABB.CCDD.EEFF\n3) AABBCCDDEEFF",
	'fixed_ip_warning'				=> 'Using fixed IP address is highly discouraged, as this breaks the ability to move modems and their CPEs freely among CMTSes. Instead of telling the customer a fixed IP address they should be supplied with the hostname, which will not change.',

 /**
  *	MODULE: ProvVoip
  */
	//PhonenumberManagementController
	'PhonenumberManagement_CarrierIn' => 'On incoming porting: set to previous Telco.',
	'PhonenumberManagement_CarrierInWithEnvia' => 'On incoming porting: set to previous Telco. In case of a new number set this to EnviaTEL',
	'PhonenumberManagement_EkpIn' => 'On incoming porting: set to previous Telco.',
	'PhonenumberManagement_EkpInWithEnvia' => 'On incoming porting: set to previous Telco. In case of a new number set this to EnviaTEL',
	'PhonenumberManagement_TRC' => 'This is for information only. Real changes have to be performed at your Telco.',
	'PhonenumberManagement_TRCWithEnvia' => 'If changed here this has to be sent to Envia, too (Update VoIP account).',
	'PhonenumberManagement_Autogenerated' => 'This management has been created automatically. Please verify/change values, then uncheck this box.',
/**
  * MODULE VoipMon
  */
	'mos_min_mult10' 				=> 'Minimal Mean Opionion Score experienced during call',
	'caller' 						=> 'Call direction from Caller to Callee',
	'a_mos_f1_min_mult10' 			=> 'Minimal Mean Opionion Score experienced during call for a fixed jitter buffer of 50ms',
	'a_mos_f2_min_mult10' 			=> 'Minimal Mean Opionion Score experienced during call for a fixed jitter buffer of 200ms',
	'a_mos_adapt_min_mult10' 		=> 'Minimal Mean Opionion Score experienced during call for an adaptive jitter buffer of 500ms',
	'a_mos_f1_mult10' 				=> 'Average Mean Opionion Score experienced during call for a fixed jitter buffer of 50ms',
	'a_mos_f2_mult10' 				=> 'Average Mean Opionion Score experienced during call for a fixed jitter buffer of 200ms',
	'a_mos_adapt_mult10' 			=> 'Average Mean Opionion Score experienced during call for an adaptive jitter buffer of 500ms',
	'a_sl1' => 'Number of packets experiencing one consecutive packet loss during call',
	'a_sl9' => 'Number of packets experiencing nine consecutive packet losses during call',
	'a_d50' => 'Number of packets experiencing a packet delay variation (i.e. jitter) between 50ms and 70ms',
	'a_d300' => 'Number of packets experiencing a packet delay variation (i.e. jitter) greater than 300ms',
	'called' => 'Call direction from Callee to Caller',
/**
 * Module Ticketsystem
 */
	'assign_user' => 'Allowed to assign an user to a ticket.',
 ];
