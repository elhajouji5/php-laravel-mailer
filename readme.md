# PHP/Laravel Mailer
This package allows sending email to a list of contacts
based on queue/job Laravel built-in APIs, it inculdes the following options:

    Send to a list of contact
    Wait a delay between sending each email
    Send email notification when sending has started/finished

## Guide
- Requirements 
    - PHP >= 7.1
    - Laravel >= 5.5
    - Redis
    - SMTP or API to send email through
    - Laravel/horizon

## Installation & configuration 


type the following commands respecting the same order as bellow:<br>
```
composer require laravel/horizon
```

```
composer require elhajouji/php-laravel-mailer
```


```
php artisan vendor:publish
```
type the number between brackets that matches **Devinweb\phpLaravelMailer\MailerServiceProvider** and hit enter<br>
E.g:<br>
```
  [1 ] Provider: Devinweb\phpLaravelMailer\MailerServiceProvider
```

and again
```
php artisan vendor:publish
```
type the number between brackets that matches **Laravel\Horizon\HorizonServiceProvider** hit enter<br>
Then
```
php artisan migrate
```
Make sure the 3 *tables failed_jobs, jobs and subscribers* have migrated
<br><br>

### *Feeding database (Optional)*

Add contacts to subscribers table (People you want to send them emails in the future)<br>
*This is the schema of subscribers table:*<br>

        +------------+------------------+------+-----+---------+----------------+
        | Field      | Type             | Null | Key | Default | Extra          |
        +------------+------------------+------+-----+---------+----------------+
        | id         | int(10) unsigned | NO   | PRI | NULL    | auto_increment |
        | name       | varchar(255)     | NO   |     | NULL    |                |
        | email      | varchar(255)     | NO   | UNI | NULL    |                |
        | created_at | timestamp        | YES  |     | NULL    |                |
        | updated_at | timestamp        | YES  |     | NULL    |                |
        +------------+------------------+------+-----+---------+----------------+

You can seed a record to that table (for testing purpose)<br>
by updating the run function of **DatabaseSeeder.php** as follow:
```php
    public function run()
    {
         $this->call(subscribersTableSeeder::class);
    }
```
and copy the class **subscribersTableSeeder.php** from _**vendor/devinweb/database/seeds**_ to _**database/seeds**_<br>
then run the artisan command
```
php artisan db:seed --class=subscribersTableSeeder
```
<br><br>

### Setting up the local machine
- Make this changes to .env file

    ###### *It's highly recommended to use redis driver for better performance*

        - QUEUE_DRIVER=redis

    **Your Redis server credentials(Below are the default credentials)**

        - REDIS_HOST=127.0.0.1
        - REDIS_PASSWORD=null
        - REDIS_PORT=6379

    **Your SMTP credentials(Example)**

        - MAIL_DRIVER=smtp
        - MAIL_HOST=smtp.mailtrap.io
        - MAIL_PORT=2525
        - MAIL_USERNAME=null
        - MAIL_PASSWORD=null
        - MAIL_ENCRYPTION=null

## How to use it

now your new service supposed to be set up and ready to use<br>
you can try it by sending a get request to the following route:<br>
```
[host]/send/{delay}/{sender name}/{sender email address}/{tag}
```

host: your domain<br>
delay: seconds to wait between sending each email<br>
sender name: the from name will appear in the header of the email<br>
sender email address  the email address will appear in the header of the email<br>
tag: a simple string to distinguish your campaigns<br>

Example:
```
http://dev.something.local/send/10/RESAL/serviceclient@resal.me/holiday
```

Once you've sent the request, run this command at the root of your project
```
php artisan horizon
````

You can watch the process of that job from this link
```
[host]/horizon    
```
E.g: http://dev.something.local/horizon

For a deeper understanding of horizon package visit this [ link ](https://laravel.com/docs/5.5/horizon)
 
<br><br><br>
#### _Please feel free to share your opinion to improve this service_ ...


<!-- 
    ### Send emails

        1. Intantiate an object of the class
                Reference to the mailer class in your controller
    ```php
            use App\Jobs\mailer;
    ```
                You can instantiate a nulled mailer object (without passing it any data)
    ```php
            $emailSender = new mailer();
    ```
                or pass an array of data to the mailer object when creating it
    ```php
            $emailSender = new mailer($data);
    ```
                However if you create a nulled mailer object you need 
                to provide the required data to that object,
                otherwise no any email will be sent

        2. Provide your data

            first you prepare your data:
            $list            = User::all(); // Contact (targeted people)
            $support["from"] = // The from name and email address
                            [
                                'address' => "senderEmail@example.com",
                                'name'    => "senderName",
                            ];
            
            $support["notify"] = "reply-me@support.com" // Where to receive notification
            // when start sending and finished sending, the from address will be used instead if not provided
            $late              = 20; // delay in seconds to wait between sending messages
            //The elay must vary from a server to another addording to its performance

            Either you pass data to the mailer object while creating it like so:
            $data = [ "list" => $list, "support" => $support, "late" => $late ];
            $emailSender = new mailer( $data );
            And you're good to go.
            Or you create a nulled object then set each of its property like so:
            $emailSender = new mailer();
            $emailSender->setProperty("list", $list);
            $emailSender->setProperty("late", $late);
            $emailSender->setProperty("support", $support);
            Then you're good to go

        3. Send the process execution to the server
            dispatch( $senderEmail );
 -->
