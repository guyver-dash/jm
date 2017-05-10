<?php


$factory->define(App\ContactData::class, function(Faker\Generator $faker){


    return [
        'mobile_no' => $faker->phoneNumber,
        'tel_no' => $faker->e164PhoneNumber,
        'messenger_acct' => $faker->safeEmail
    ];

});

$factory->define(App\ContactAddress::class, function(Faker\Generator $faker){

    $contactData = factory(App\ContactData::class)->create();

    return [
        'contact_data_id' => $contactData->id,
        'country_id' => 173,
        'province_id' => 5025,
        'city_id' => rand(48013, 48065),
        'brgy_id' => null,
        'street_lot_blk' => $faker->streetAddress ,
        'longitude' => $faker->longitude($min = -180, $max = 180),
        'latitude' => $faker->latitude($min = -90, $max = 90),
    ];

});

$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

     $personal_data = factory(App\PersonalData::class)->create();

     $contactData = factory(App\ContactAddress::class)->create();

    return [
        'contact_data_id' => $contactData->id,
        'personal_data_id' => $personal_data->id,
        'member_id' => $faker->swiftBicNumber ,
        'account_no' => $faker->swiftBicNumber,
        'email' => $faker->unique()->safeEmail,
        'status' => rand(0,1),
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\PersonalData::class, function (Faker\Generator $faker) {


    $name = $faker->name;

    return [
        'gender_id' => rand(1, 3) ,
        'firstname' => $name[0],
        'lastname' => $name[1],
        'middlename' => 'MiddleName',
        'mothers_maiden_name' => $name[1],
        'nationality' => 'Filipino',
        'birthdate' => $faker->dateTimeThisCentury->format('Y-m-d'),
        'birthplace_city_id' => rand(1,5),
        'marital_status' => rand(1, 5)
    ];
});



$factory->define(App\CardNo::class, function (Faker\Generator $faker) {


    $user = factory(App\User::class, 1)->create();

    $user[0]->roles()->attach($user[0]->id, [

                    'role_id' => rand(1, 12),
                    'user_id' => $user[0]->id
                ]);

    return [

        'user_id' => $user[0]->id,
        'card_no' => $faker->creditCardNumber,
        
    ];
});

$factory->define(App\Merchant::class, function(Faker\Generator $faker){

    $user = factory(App\User::class, 1)->create();

    $user[0]->roles()->attach($user[0]->id, [

                    'role_id' => rand(1, 12),
                    'user_id' => $user[0]->id
                ]);

    return [
        'created_by' => $user[0]->id,
        'name' => $faker->company,
        'email' => $faker->email,
        'website' => 'http://www.'.$faker->domainName,
        'phone_no' => $faker->tollFreePhoneNumber,
        'mobile_no' => $faker->e164PhoneNumber
    ];
});

$factory->define(App\Branch::class, function(Faker\Generator $faker){

    $merhant = factory(App\Merchant::class, 1)->create();

    return [

            'merchant_id' => $merchant[0]->id,
            'created_by' => $user->id,
            'phone_no' => $faker->tollFreePhoneNumber,
            'mobile_no' => $faker->e164PhoneNumber,
    ];
});

$factory->define(App\MainCategory::class, function(Faker\Generator $faker){

    $user = factory(App\User::class, 1)->create();

    $user[0]->roles()->attach($user[0]->id, [

                    'role_id' => rand(1, 12),
                    'user_id' => $user[0]->id
                ]);

    return [

        'user_id' => $user[0]->id,
        'name' => $faker->word . ' ' . $faker->word,
        'desc' => $faker->sentence($nbWords = 6, $variableNbWords = true)

    ];
});


$factory->define(App\MerchantCategory::class, function(Faker\Generator $faker){

       
        $mainCat = factory(App\MainCategory::class, 1)->create();


    return [

        'user_id' => $mainCat[0]->user_id,
        'maincategory_id' => $mainCat[0]->id,
        'name' => $faker->word . ' ' . $faker->word,
        'desc' => $faker->sentence($nbWords = 6, $variableNbWords = true)
    ];

});


$factory->define(App\MerchantSubcategory::class, function(Faker\Generator $faker){

     $merchantcategory = factory(App\MerchantCategory::class, 1)->create();

    return [
         'user_id' => $merchantcategory[0]->user_id,
         'merchant_category_id' => $merchantcategory[0]->id,
         'name' => $faker->sentence($nbWords = 3, $variableNbWords = true),
         'desc' => $faker->sentence($nbWords = 6, $variableNbWords = true)
    ];
});


$factory->define(App\Product::class, function(Faker\Generator $faker){

     $merchantSub = factory(App\MerchantSubcategory::class, 1)->create();

    return [
         'user_id' => $merchantSub[0]->user_id,
        'merchant_subcategory_id' => $merchantSub[0]->id,
        'name' => $faker->word . ' ' . $faker->word,
        'model_number' => $faker->isbn13,
        'unit_id' => rand(1, 4),
        'desc' => $faker->text($maxNbChars = 100),
        'discount' => $faker->numberBetween(1, 99)

    ];
});

$factory->define(App\Photo::class, function(Faker\Generator $faker){

    $product = factory(App\Product::class)->create();
    return [

        'path' => 'images/uploads/' . rand(1,67) . '.jpg',
        'imageable_id' => $product->id,
        'imageable_type' => 'App\Product',
        'is_primary' => 1
    ];
});


$factory->define(App\Price::class, function(Faker\Generator $faker){

    $product = factory(App\Product::class)->create();
    return [

        'product_id' => $product->id,
        'price' => $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 100000),
        'is_primary' => 1
    ];
});

