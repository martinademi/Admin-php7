<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of StripeModule
 *
 * @author admin3embed
 */
require_once('stripe-php-3.20.0/init.php');

class StripeModuleNew {

    public function __construct() {

        \Stripe\Stripe::setApiKey(Stripe_Id);
    }

    public function CreateAccount($args) {

        if (STANDALON_OR_MANAGED == false) {
            $res = \Stripe\Account::create(array(
                        "managed" => STANDALON_OR_MANAGED,
                        "country" => "AU",
                        "email" => $args['email']
            ));
        } else {
            $res = \Stripe\Account::create(array(
                        "managed" => STANDALON_OR_MANAGED,
                        "country" => "AU"
            ));
        }
        return $res;
    }

    // transfer amount which has been added to our stripe account 

    public function TranseferAmount($args) {
        if (STANDALON_OR_MANAGED == false) {
            $res = \Stripe\Transfer::create(array(
                        "amount" => $args['amount'],
                        "currency" => $args['currency'],
                        "destination" => $args['destination'],
                        "description" => "Transfer for " . $args['email']
            ));
        } else {
            $res = \Stripe\Transfer::create(
                            array(
                        "amount" => $args['amount'],
                        "currency" => $args['currency'],
                        "destination" => "ba_18v7nwLhVV55mcjQnH9ayHlx",
                            ), array("stripe_account" => $args['CONNECTED_STRIPE_ACCOUNT_ID'])
            );
        }

        return $args;
    }

    public function schedule($args) {

        $account = \Stripe\Account::retrieve($args['acc_id']);
        $account->transfer_schedule->interval = "manual";
        $datafatersalve = $account->save();
        return $datafatersalve;
    }

    public function CreateTransfer($args) {
        $res = \Stripe\Transfer::create(array(
                    "amount" => $args['amount'],
                    "currency" => $args['currency'],
                    "destination" => $args['CONNECTED_STRIPE_ACCOUNT_ID'],
                    "description" => $args['description']
        ));
        return $res;
    }

    public function updateAccountInfo($args) {

        $account = \Stripe\Account::retrieve($args['acc_id']);
        $account->legal_entity->dob->day = $args['day'];
        $account->legal_entity->dob->month = $args['month'];
        $account->legal_entity->dob->year = $args['year'];
        $account->legal_entity->first_name = $args["first_name"];
        $account->legal_entity->last_name = $args["last_name"];
        $account->legal_entity->type = "individual";

        $account->legal_entity->address->city = $args["city"];
        $account->legal_entity->address->line1 = $args["line1"];
        $account->legal_entity->address->postal_code = $args["postal_code"];
        $account->legal_entity->address->state = $args["state"];
        $account->tos_acceptance->date = time();
        $account->tos_acceptance->ip = $_SERVER['REMOTE_ADDR'];
        $account->legal_entity->personal_id_number = $args["personal_id_number"];
        $datafatersalve = $account->save();
        return $datafatersalve;
    }

    public function BankAccountDefault($args) {


        $account = \Stripe\Account::retrieve($args['accountId']);
        $bank_account = $account->external_accounts->retrieve($args['externale_accId']);
        $bank_account->metadata['default_for_currency'] = $args['makedefault'];
        $res = $bank_account->save();
        return $res;
    }

    public function IdentifyiVerification($args) {

        $verification = \Stripe\FileUpload::create(
                        array(
                    "purpose" => "identity_document",
                    "file" => fopen($args['IdProoF'], 'r')
                        ), array("stripe_account" => $args['acc_id'])
        );

        if ($verification['error']) {
            $data = array('flag' => 1, 'msg' => $customer['result']['code']);
        } else {
            $account = \Stripe\Account::retrieve($args['acc_id']);
            $account->legal_entity->verification->document = $verification['id'];
            $account->save();
            $data = array('flag' => 0, 'account' => $account);
        }
        return $verification;
    }

    /////////////////////////////////////////////////
    // link your bank account to your stripe account
    // accutId is => stripe account id
    // external_accId => bank account id which you got from stripe.js
    // in case of managed

    public function CreateAnBankAccout($args) {
        $account = \Stripe\Account::retrieve($args['accountId']);
        $res = $account->external_accounts->create(array("external_account" => $args['externale_accId'], "default_for_currency" => true));
        return $res; // id gets return form here which will be used for to retrive bank account info 
    }

    public function updateDefaultCurrncy($args) {
        $account = \Stripe\Account::retrieve($args['accountId']);
        $res = $account->external_accounts->create(array("external_account" => $args['externale_accId'], "default_for_currency" => true));
        return $res; // id gets return form here which will be used for to retrive bank account info 
    }

    public function DeleteABankAccount($args) {
        $account = \Stripe\Account::retrieve($args['accountId']);
        $res = $account->external_accounts->retrieve($args['externale_accId'])->delete();
        return $res;
    }

    // accountId => managed acc_id

    public function RetriveABankAccount($args) {
        $account = \Stripe\Account::retrieve($args['accountId']);
        $bank_account = $account->external_accounts->retrieve($args['BankAccountTocken']);
        return $bank_account;
    }

    public function RetriveStripConnectAccount($args) {
        $account = \Stripe\Account::retrieve($args['accountId']);
        return $account;
    }

    ////////////////////////////////////////////////
    public function RetriveTransefer($args) {
        $res = \Stripe\Transfer::retrieve($args['trx_id']);
        return $res;
    }

    public function apiStripe($method, $args) {

        try {

            return $this->{$method}($args);
        } catch (Stripe_CardError $e) {
            // Since it's a decline, Stripe_CardError will be caught

            return $e->getJsonBody();
        } catch (Stripe_InvalidRequestError $e) {
            return array("error" => array("message" => "Invalid parameters were supplied to Stripes API", "det" => $e));
        } catch (Stripe_AuthenticationError $e) {
            return array("error" => array("message" => "Authentication with Stripes API failed"));
            // (maybe you changed API keys recently)
        } catch (Stripe_ApiConnectionError $e) {
            return array("error" => array("message" => "Network communication with Stripe failed"));
        } catch (Stripe_Error $e) {
            return array("error" => array("message" => "Error occured!"));
            // yourself an email
        } catch (Exception $e) {
            return array("error" => array("message" => "Something else happened, completely unrelated to Stripe", "e" => $e));
        }
    }

}
?>


