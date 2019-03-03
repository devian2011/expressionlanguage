# Язык для написания логических и математических условий,получения информации о сущностях, или получения каких-то значений основываясь на указанных сущностях


## Операторы и порядок их работы 

| Порядок   | Название | Символы   |
|---|---------------------|----|
| 1 | Умножение / деление | * /| 
| 2 | Сложение / вычитание | + - |
| 3 | Больше / меньше | > < >= <= |
| 4 | Равно / Не равно | == != |
| 5 | И | && |
| 6 | Или | \|\| |

## Функции

Язык поддерживает функции. Функции работают так же как и операторы, 
но функционал переопределение функций и операторов отстутствует для большей надёжности

### Список стандартных функций

| Название | Входящие параметры | Что возвращает|
|-------|-------|-------------------------------------------|
| count | array | возвращает количество элементов в массиве |

### Добавление своих функций

При создании экземпляра интерпретатора добавляем функцию через метод addFunction
первым передаём строку с названием, вторым, функцию замыкания, может быть указано любое количество параметров,
все они передадутся 

```php
use Devian\ExpressionLanguage\EntityExpressionLanguage;
use Devian\ExpressionLanguage\Resolvers\Entities\DefaultEntityResolver();

$language = new ExpressionLanguage(new DefaultEntityResolver());
$language->addFunction('hello', function($name) { return "Hello {$name}" } );

echo $language->execute('hello("Dolly")');
// Output: Hello Dolly
```


## Константы

Обычные константы как и в любой функции, 3, 5, 4.2
Все строчные константы ОБЯЗАТЕЛЬНО указывать в двойных кавычках - к примеру "Hello I'm Frank"

## Cущности и доступ к ним

Можно использовать любой резолвер сущностей по желанию, главное чтобы он реализовывал интерфес 
Devian\ExpressionLanguage\Resolvers\Entities\EntityResolverInterface

Есть так же дефолтовый резолвер. На вход ему необходимо передать MAP с сущностями.
При вызове GetValue он сперва проверяем полное совпадение в словаре, если полного совпадения нет, то пытается
разбить строку на ключи и вызывать каждый ключ по цепочке последовательно.

Сущности и доступ к ним осуществляется через точку. Т.е. - "сущность.свойство.свойство.свойство"
ТОЧКА обязательна!!!
Так же можно напрямую указать строковым выражением 'hello.name'.

К примеру
```php
    $resolver = new DefaultEntityResolver();
    $resolver->registerEntities([
        'person.name' => 'Hero.name',
        'client' => new Client();
    ]);
    
    echo $resolver->getValue('person.name');
    //Output: 'Hero.name'
    echo $resolver->getValue('client.number');
    // Сперва он проверит если полное вхождение client.number. Если нет значит будет парсинг строки и client.name превратиться в client -> name
    // Теперь резолвер попробует найти client (если не найдёт выбросит RuntimeErrorException) далее проверит объект это или массив.
    // И по пути ['client','name'] будет пытаться найти или само свойство или его Getter.
    // Можно в принципе передавать сущности из Doctrine всё вызывается последовательно, так что он точно так же заберёт все данные
    
```

## Пример использования

```php
use Devian\ExpressionLanguage\ExpressionLanguage;
use Devian\ExpressionLanguage\Resolvers\Entities\DefaultEntityResolver;

$defaultEntityResolver = new DefaultEntityResolver();
$defaultEntityResolver->registerEntities([
    'client.task' => [1, 2, 3, 4, 5, 6],
    'client.priority' => 4,
    'person.name' => 'Hero.name',
]);

$string = '(count(client.task) + client.priority > 9) && person.name == "Hero.name"';
$lang = new ExpressionLanguage($defaultEntityResolver);
$result = $lang->execute($string);
var_export($result);
echo PHP_EOL;
//Output: true

$string = 'person.name';
echo $lang->execute($string)
//Ouput: Hero.name

$string = 'count(client.task) + client.priority';
echo $lang->execute($string);
//Output: 10
```