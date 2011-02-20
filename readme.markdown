## PAPI - PHP API Framework ##
A tiny, very fast, JSON based API system for PHP applications. 

Simply define your model's methods, with the correct data-types, and this system takes care of validating all input. Think of it like taking a MVC framework, throwing out the controllers, libraries, views. Then only using models and having a system smart enough to figure out the correct (and only the correct) type of data each model method needs before allowing that method to run.

No Form Views, No Validation Libraries, no Controllers.

Your model knows what data it needs - and PAPI knows how to insure that only safe data *matching that type* makes it through, while gracefully handling errors in a way that can be passed back to your frontend JavaScript for highlighting incorrect fields or alerting the user.

If your site relies heavily on jQuery and *AJAX* then this might be the most useful framework you have ever seen. In a mater of minutes you can build a model, add the required CRUD methods, and alert you JavaScript team to start using it! You could even use it to build a public, web-facing API for your application!

See the sample index.html file for a way to test your API's (It uses the kB Framework but any JavaScript library will work).

Released under the MIT License

[David Pennington](http://xeoncross.com)