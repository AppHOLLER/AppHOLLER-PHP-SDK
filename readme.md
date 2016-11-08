Holler PHP SDK
-------------

The Holler PHP SDK gives you access to the powerful Holler from your PHP app or script.

Installation
------------

[Get Composer], the PHP package manager. Then create a composer.json file in  your projects root folder, containing:

```json
{
    "require": {
        "rainmakerlabs/holler-php-sdk" : "dev-master"
    }
}
```

Run "composer install" to download the SDK and set up the autoloader,
and then require it from your PHP script:

```php
require 'vendor/autoload.php';
```

Note: The Holler PHP SDK requires PHP 5.4 or newer.

Alternative Method
------------------

If you don't want to use Composer, you can include the ```autoload.php```
file in your code to automatically load the Holler SDK classes.

```php
require 'autoload.php';
```

Initialization
---------------
You need to go to Holler webiste to register an account and setup configuration of your application before use this SDK
After including the required files from the SDK, you need to initalize the HollerClient using your Holler API keys:
Check out the [Holler PHP API Document] for the full documentation.

```php

use Rainmakerlabs\Holler\Helper\HollerClient;
HollerClient::initialize("HOLLER-APP-ID", "HOLLER-ACCESS-KEY");

```



Usage
-----


Add the "use" declarations where you'll be using the classes. For all of the
sample code in this file:

```php
use Rainmakerlabs\Holler\Services\HollerSDK;
```

Subscriber:

```php

$hollerSDK = new HollerSDK();


// ======= Register new Subscriber ======

$subscriber_model = $hollerSDK->subscriber();

// set main values
$subscriber_model->setEmail("youremail@test.com");
$subscriber_model->setUsername("yourusename");
$subscriber_model->setPhone("65 111111111");
$subscriber_model->setFirstName("Tom");
$subscriber_model->setLastName("Cruise");
$subscriber_model->setIsActive(true);

// set subscriber information
$subscriber_info = self::$holler->subscriberInfo();
$subscriber_info->setCountry("SG");
$subscriber_info->setDateOfBirth("1991-10-01");
$subscriber_info->setInterestId(11);
$subscriber_model->setInfo($subscriber_info);

// register subscriber
$subscriber = $subscriber_model->register();

// ======= Update subscriber ======

$subscriber_model = $hollerSDK->subscriber();

$subscriber_model->setFirstName("Tommy");

$subscriber_info = self::$holler->subscriberInfo();
$subscriber_info->setCountry("VN");
$subscriber_model->setInfo($subscriber_info);

$subscriber = $subscriber_model->update($subscriber_id);

// ====== Get list of subscriber ========

$subscriber_model = $hollerSDK->subscriber();
$subscriber_list = $subscriber_model->paginate($page);
$all_subscribers = $subscriber_model->all();


// ====== Get subscriber communication history ========

$subscriber_model = $hollerSDK->subscriber();
$result = $subscriber_model->getCommunications($subscriber_id);

// Filter only push
$push = $subscriber_model->getCommunications($subscriber_id, 'push');
// Filter only sms
$sms = $subscriber_model->getCommunications($subscriber_id, 'sms');
// Filter only email
$email = $subscriber_model->getCommunications($subscriber_id, 'email');


// ====== Delete subscriber communication by communication id ========

$subscriber_model = $hollerSDK->subscriber();
$communicationId = [1, 2, 3];
$result = $subscriber_model->deleteCommunications($subscriber_id, $communicationId);


// ====== Get total subscriber ========

$subscriber_model = $hollerSDK->subscriber();
$result = $subscriber_model->total();


```

Communication:


```php

$hollerSDK = new HollerSDK();

// ==== Get all list of communication ====

$data = $hollerSDK->communication()->all();

// ==== Get detail of communication by id ====

$communication_model = $hollerSDK->communication();
$communication = $communication_model->find($communication_id);


// ====== Create a new communication campaign ====

$time_to_send  = date("Y-m-d H:i:s",strtotime("+5 minutes"));

$communication = $hollerSDK->communication();
// set name and description
$communication->setName("title of communication" );
$communication->setDescription("this is a short description");
// set channel (email, sms, pushnotification)
$communication->setChannel('email',
    ['subject'=>'subject here '.$time_to_send,'content'=>'You content is here','from'=>"from@youremail.com"]);
    
// setup target
$target = $hollerSDK->communicationTarget();

// segment target
$segment = $hollerSDK->communicationTargetSegment();
$segment->setInterest(12);
$segment->setAge(10,20);

$target->setSegment($segment);

// add target to communication
$communication->setTarget($target);

// set cover image for your communication
$cover_img = new \CURLFile('your path file','image/jpeg','filename.jpg');
$communication->setCoverImg($cover_img);

// set time to publish communication
$communication->setTime( date("Y-m-d H:i:s",strtotime("+5 minutes")));
$communication_id =$communication->create();



// ====== Update communication =========
$communication = $hollerSDK->communication();
$communication->setName("Eddited name" );
// setup target
$target = $hollerSDK->communicationTarget();

// segment target
$segment = $hollerSDK->communicationTargetSegment();
$segment->setAge(18,100);
$target->setSegment($segment);
// add target to communication
$communication->setTarget($target);

$communication_id = $communication->update($communication_id);

```


Location:

```php

$hollerSDK = new HollerSDK();

//====== Get all location lists ======
$locations = $hollerSDK->location()->all();

//==== Create/Find/Update a location ====== 
$location_model = $hollerSDK->location();
// set location value to create
$location_model->setGpsLatitude("100.023423423");
$location_model->setGpsLongitude("10.02342344");
$location_model->setRadius(10);
$location_model->setLocationName("Location Name Testing ");
$location = $location_model->create();


// get detail data of location
$location_model = $hollerSDK->location();
$location = $location_model->find($location_id);

// update a location
$location_model = $hollerSDK->location();
$location_model->setLocationName("Location name edited");
$location = $location_model->update($location_id);

```

Target:

```php

$hollerSDK = new HollerSDK();

// ===== Get all target ====
$target_data = $hollerSDK->target()->get();

//====== Get active target only =====
$active_target = $hollerSDK->target()->getActive();


```


Designation:

```php

$hollerSDK = new HollerSDK();

// get all list of designation
$list_of_designation = $hollerSDK->designation()->all();

// create a new designation
$designation_model = $hollerSDK->designation();
$designation_model->setDesignationName("Designation Name");
$designation_model->setIsPublished(true);
$designation = $designation_model->create();


// find a designation
$designation_model = $hollerSDK->designation();
$designation = $designation_model->find($designation_id);


// update a designation
$designation_model = $hollerSDK->designation();
$designation_model->setDesignationName("Designation Name  edited");
$designation = $designation_model->update($designation_id);

```


Industry:

```php

$hollerSDK = new HollerSDK();

// get all list of industry
$list_of_industry = $hollerSDK->industry()->all();

// create a new industry
$industry_model = $hollerSDK->industry();
$industry_model->setIndustryName("Industry Name");
$industry_model->setIsPublished(true);
$industry = $industry_model->create();


// find a industry
$industry_model = $hollerSDK->industry();
$industry = $industry_model->find($industry_id);


// update a industry
$industry_model = $hollerSDK->industry();
$industry_model->setIndustryName("Industry Name  edited");
$industry = $industry_model->update($industry_id);

```


Interest:

```php

$hollerSDK = new HollerSDK();

// get all list of interest
$list_of_interest = $hollerSDK->interest()->all();

// create a new interest
$interest_model = $hollerSDK->interest();
$interest_model->setInterestName("Interest Name");
$interest_model->setIsPublished(true);
$interest = $interest_model->create();


// find a interest
$interest_model = $hollerSDK->interest();
$interest = $interest_model->find($interest_id);


// update a interest
$interest_model = $hollerSDK->interest();
$interest_model->setInterestName("Interest Name  edited");
$interest = $interest_model->update($interest_id);

```


Error definition
---------------
- ModelNotFoundException : When you try to get or update a record that it does not exist
- AuthenticationException : When you login subscriber with invalid credentials
- CommunicationException : All error relate to communication model
- InvalidRequestDataException : When you send invalid data to Holler
- MethodNotAllowException : When you try to send an incorrect method
- PermissionDenyException : When you don't have permission to do an action
- WrongParameterException : Wrong parameter passed
- UnknownErrorException : Other unknown exception
- HollerExceptions: Default error exception in Holler PHP SDk


[Get Composer]: https://getcomposer.org/download/
[Holler PHP API Document]: http://appholler.com/api-docs/
