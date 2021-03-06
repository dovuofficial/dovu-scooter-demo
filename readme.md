
# DOVU API - Scooter Demo App

This is Scooter, a demo app based on a boilerplate [Laravel](https://github.com/dovuofficial/scooter/blob/master/laravel.md) project that uses MySQL.

The goal of this project is to give partners and clients an insight into using the API in a real application, we encourage experimentation to understand the OAuth process of working and linking of DOVU users with the API.

This is our [API documentation](https://developer.dovu.dev/?version=latest) although it focuses on our dovu.dev testnet environment the process is the same for our production dovu.earth.

# The DOVU API

At a high level the API has two approaches:

1. Create offers that can be redeemed with DOV tokens which help to offset carbon.
2. Create behavioural triggers for when a user has completed a task to reward them with DOV tokens.

## An example to offset the carbon from Bitcoin transactions

An example for the crypto community would be to create an **offer** to offset the carbon of a [single Bitcoin transaction](https://digiconomist.net/bitcoin-energy-consumption).

By tracking the transactions from the submitted Bitcoin address of your user, you may automatically **redeem** the **offer** through your users, therefore automatically offsetting every bitcoin transaction for a user.

If a users balance becomes too low to make the payment then you could send out emails or notifications from your service to warn them of the issue.

If the rate of Bitcoin transactions reduced over time that might be an indication that your user has taken positive action in changing their behaviour, which may warrant a **reward** in DOV.

# Get Started

## Become a Partner

1. Create a wallet account on [dovu.dev](https://dovu.dev)
2. Request **partner** access from our support team, see the [documentation](https://developer.dovu.dev/?version=latest).
3. When **partner** access has been granted check the footer of [dovu.dev](https://dovu.dev) and you should see a new [**CLIENT APPS**](https://dovu.dev/client-app) link this will allow you create new client applications.

## Start with Scooter

1. Clone the repo.
2. Run `make create` to install all of the dependices for the project and migrate the database.
    * You may have to manually add a **dovu_scooter** db
    * The generated **DB_USERNAME** is **forge**, update the db credentials as required.
3. Run `make start` to serve the app
4. On a separate terminal tab run `make expose` to get a external endpoint to the app.

## Create a DOVU Client App for scooter

1. From the [Client Apps](https://dovu.dev/client-app) page click **Create New Client** add a name and redirect URI, then click **Create**.
    * The redirect URI will be the exposed endpoint appended with **/callback** see the [web routes file](https://github.com/dovuofficial/scooter/blob/master/routes/web.php).
2.  With the newly generated client inside of **OAuth Clients** copy the **Client ID** and **Secret** into the **.env** of your **Scooter** app.
    * Update **DOVU_API_CLIENT_ID=** with the **Client ID**.
    * Update **DOVU_API_CLIENT_SECRET=** with the **Secret**.
3. Restart the local **Scooter** app with **cmd + c** and rerun ``make start``.

You should now be able to create scooter users and link a DOVU user, when a user from scooter submits an issue the respective DOVU user will receive an award of **0.01 DOV**.

If you have an Android device you can download a [DOVU Testnet Version](https://dovu.io/app/testnet/DOVU_Dev_Release.apk) of the app, log in and see the notifications come in when the DOVU user is rewarded.

# Experimenting with the testnet API

Inside of the codebase take a particular look at these files to get a deeper understanding of the process and how users are rewarded with tokens.

- [config/dovu.php](https://github.com/dovuofficial/scooter/blob/master/config/dovu.php)
- [app/Services/DovuAuthorizationService](https://github.com/dovuofficial/scooter/blob/master/app/Services/DovuAuthorizationService.php)
- [app/Controllers/DovuController](https://github.com/dovuofficial/scooter/blob/master/app/Http/Controllers/DOVUController.php)
- [app/Controllers/IssueController](https://github.com/dovuofficial/scooter/blob/master/app/Http/Controllers/IssueController.php)

It is easier to navigate the structure of the database if you are using a MySQL client such as [SequelPro](https://www.sequelpro.com/)

Use the **Scooter** test project within **dovu.dev** as a sandbox to experiment with the DOVU API.

You may also create new redeemable offers which your users may purchase as a method of offsetting carbon using DOV tokens.

When you are ready to start working with real tokens on production let us know.
