<?php
 require("stripe/init.php");
 \Stripe\Stripe::setApiKey("sk_test_y4YRaiqoPSqai5CEvpXTbA5A");
class PaymentFunctions {

 function CreateNewCustomer($token, $email) {

        \Stripe\Stripe::setApiKey("sk_test_y4YRaiqoPSqai5CEvpXTbA5A");
        $customer = \Stripe\Customer::create(array(
                    "description" => $email,
                    "email" => $email,
                    "source" => $token // obtained with Stripe.js
        ));
        return $customer->id;
   }

    
 function payInvoice($token,$customer_id,$amount)
 {
    \Stripe\Stripe::setApiKey("sk_test_y4YRaiqoPSqai5CEvpXTbA5A");

   $card_charge = \Stripe\Charge::create(array(		 
					  "amount" => "3000",
					  "currency" => "usd",
					  "customer" =>  $customer_id ,
					 "description" => "Membership fee 2"
							));
   
   echo "<pre>"; print_r($card_charge); die;
    
 }
 
    function deleteExistingPlan($plan_id)
   { 
       
       \Stripe\Stripe::setApiKey("sk_test_y4YRaiqoPSqai5CEvpXTbA5A");

       $plan = \Stripe\Plan::retrieve($plan_id);
       $plan->delete();
       return "success";

   }
 
  function createNewPlan($plan_name,$plan_id,$amount)
   {
     
        \Stripe\Stripe::setApiKey("sk_test_y4YRaiqoPSqai5CEvpXTbA5A");

        $plan = \Stripe\Plan::create(array(
          "name" => $plan_name,
          "id" => $plan_id,       
          "interval" => "month",
           "interval_count"=>1,
          "currency" => "usd",
          "amount" => $amount,
        ));

        return $plan->id;
   } 
   function partialRefund()
   {

        \Stripe\Stripe::setApiKey("sk_test_y4YRaiqoPSqai5CEvpXTbA5A");
         $refund= \Stripe\Refund::create(array(
              "charge" => "ch_1AKQfyIOl9zIOmcSUUITgeVv",
              "amount" => 150,
             ));
         echo "<pre>"; print_r($refund); die;
   }
 function createSubscription($customer_id,$plan_id,$timestamp)
 {

    \Stripe\Stripe::setApiKey("sk_test_y4YRaiqoPSqai5CEvpXTbA5A");
         //"billing_cycle_anchor"=>$timestamp
      $subscription = \Stripe\Subscription::create(array(
         "customer" => $customer_id,
          "billing_cycle_anchor"=>$timestamp,
          "plan" => $plan_id
     ));

     $subscription_id = $subscription->id; 
     return $subscription_id;
 }

 function updateSubscription($existing_subscription_id,$new_plan)
 {  


    \Stripe\Stripe::setApiKey("sk_test_y4YRaiqoPSqai5CEvpXTbA5A");
    $subscription = \Stripe\Subscription::retrieve($existing_subscription_id);
    $subscription->plan = $new_plan;
    $subscription->save();
    return;
 }
 function cancelSubscription($subscription_id)
 {
     \Stripe\Stripe::setApiKey("sk_test_y4YRaiqoPSqai5CEvpXTbA5A");
      $subscription = \Stripe\Subscription::retrieve($subscription_id);
      $subscription->cancel();
      return;
 }
 
 function generateInvoice($customer_id)
 {

   /*\Stripe\Stripe::setApiKey("sk_test_y4YRaiqoPSqai5CEvpXTbA5A");


            \Stripe\InvoiceItem::create(array(
                "customer" => $customer_id,
                "amount" => 1300,
                "currency" => "usd",
                "description" => "One-time setup fee2")
            );

            \Stripe\InvoiceItem::create(array(
                "customer" => $customer_id,
                "amount" => 1100,
                "currency" => "usd",
                "description" => "One-time setup fee1")
            );

                $t= \Stripe\Invoice::create(array(
                "customer" =>$customer_id,

            ));
     
echo "<pre>"; print_r($t); die;
 */

 }
    

} 



?>