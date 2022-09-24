![Fosa](./static/favicon/favicon.ico?raw=true)

# Fosa

Fosa framework is free and open PHP based web framework build for endemic developer. You use the beta version 0.1 of the framework. Official 1.0 version will be released soon. Enjoy and contribute too !

## Installation

**Note:** Fosa requires `PHP:~5.4` and above.

Use the `git clone` command to install to clone current repository or download directly source code. Release version will be updated soon.

## Launch

To start your Fosa app server, type the following command on your console:

```bash
php server/run
```

Note : The server will run at `localhost` on port `8085` but you can change this by editing `R_HOST` and `R_PORT` in *.env* file in the root directory of your app.

## Documentation

### Controllers
The create a new controller, open the folder located at `controllers` and create a new PHP class file in. Then to configure the controller as shown in the bellow :

```php
namespace Fosa\Controllers;

use Fosa\Application\Controller;
use Fosa\Application\Request;
use Fosa\Application\Response;

class MyFosaController extends Controller
{
    public function __construct($method, Request $request, Response $response)
    {
        parent::__construct($method, $request, $response);
    }

    public function index(Request $request, Response $response)
    {
        return $response->view('fosa-template', [
            'message' => 'Hello, World!',
            'random' => 'Some data passed to the view.'
        ]);
    }
}
```

Then, now we are going to create the view `fosa-template`.

### Templates

View in Fosa Framework is located at `templates`. Templates are renderer by a class named `Template`, the class provides too some methods that will be usable in the template file. To create a new template, we are going to create a file named `fosa-template.template.php` :

```php
echo $data['message'];
echo $data['random'];
```

All methods provided by the class `Template` are :

| Methods        | Description           | Results  |
| ------------- |:-------------:| -----:|
| `get_locale()`      | Get the current locale. | `en-EN` or `fr-FR` |
| `assets($dir, $name)`      | Get URL of assets located in `statics` folder.      |  `/statics/images/Fosa.png`  |
| `render_locale($key)` | Return translated key based text located in `/application/locales/<locale>/translation.php`      |    `Welcome` or `Bienvenue` |

### Routing

The routing configuration is in file `index.php` located in at the root project directory, you can easily register new route by using `Router` instance `$router` :

```php
...

use Fosa\Controllers\MyFosaController;

$router = new Router();

/* WEB routes */
$router->route('/my-fosa-controller', 'GET', MyFosaController::class);

...
```

And the, you can access to your URL `http://localhost:8085/my-fosa-controller` .
## Issues

Somme features are not ready in this beta version of the app, please tell us if you have an issue. And don't forget that Fosa is community open project.

## Contribution

FOsa is an OpenSource project, any contribution would be welcomed with joy. For major changes, please contact the authors of the project.

## Creator

Fosa is an project started by Malagasy young developer. Meet the creator and don't forgot to follow for new features.

[Finoana Mendrika](https://github.com/finoanamendrika)

## License
[MIT](https://choosealicense.com/licenses/mit/)