## php-cli-script
I wrote this script as my submission to the test given to me by a possible employer as part of my interview process.

One of the main criteria is to "keep it simple". Now I know that this is a very simple request but think about it... 
In the real world, this command may be extended to have more searches ie. search by artist name, id etc. In the real world, 
it is important to have applications that can easily scale by adding just a few lines of code; else some other developer 
hit's me in the head :D.

So I decided to let loose... just a bit to satisfy scalability. The codebase is still simple in it's implementation and ties to 
a mini framework utilizing some packages.

### Requirments

* PHP 7
* Composer
* Orange Juice (it's so simple you would not need coffee)

### Installation

* Clone this repository on your local machine
    
  ``git clone https://github.com/sonoftheweb/php-cli-script.git``
  
* Run composer install

  ``composer install``
  
* Run dump-autoload

  ``composer dump-autload``
  
##### To run search:

``./cosset_test_cli search Halifax``

 Enjoy!
