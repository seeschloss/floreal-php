# floreal
## Usage ##

### FlorealDate::__construct($unix_timestamp) ###
Creates a new date object with its date set to `$unix_timestamp` (seconds since 1970-01-01).

```php
$date = new FlorealDate(-5369241600);
echo $date
```
will output:

    18 brumaire, an VIII

### FlorealDate::__construct($republican_year, $republican_month, $republican_day) ###
Creates a new date object a set date.

```php
$date = new FlorealDate(8, 2, 18);
echo $date
```
will output:

    18 brumaire, an VIII

### FlorealDate::to_full_date_string() ###
Returns the full date in long form as "[day number] [month name], an [year in roman numerals]"

```php
$date = new FlorealDate(-5369241600);
echo $date->to_full_date_string();
```
will output:

    18 brumaire, an VIII

### FlorealDate::__toString() ###
This is a "magic method" that PHP uses to automatically convert Objects to strings. The output is identical to `FlorealDate::toFullDateString()`.

```php
$date = new FlorealDate(-5369241600);
echo $date
```
will output:

    18 brumaire, an VIII

### FlorealDate::to_short_date_string() ###
Returns the full date in short form as "[day number]-[month number]-[year in roman numerals]"

```php
$date = new FlorealDate(-5369241600);
echo $date->to_short_date_string();
```

will output:

    18-02-VIII

### FlorealDate::set_republican_date($republican_year, $republican_month, $republican_day) ###
Sets the full Republican date

```php
$date = new FlorealDate();
$date->set_republican_date(8, 2, 18);
echo $date
```
will output:

    18 brumaire, an VIII

### FlorealDate::republican_year() ###
### FlorealDate::republican_year_decimal() ###
Displays year of the Republic as a decimal number

### FlorealDate::republican_year_roman() ###
Displays year of the Republic as roman numerals

```php
$date = new FlorealDate(8, 2, 18);
echo $date->republican_year();
echo $date->republican_year_roman();
```
will output:

    8
    VIII

### FlorealDate::is_year_sextile() ###
Returns true if year is sextile, using actual sextile years for years I to XVI, and [Romme system](http://gallica.bnf.fr/ark:/12148/bpt6k826927/f328.image.r) for subsequent years.

```php
echo (FlorealDate(8, 11, 9))->is_year_sextile();
echo (FlorealDate(11, 11, 30))->is_year_sextile();
```
will output:

    false
    true

### FlorealDate::first_day_of_year() ###
Returns the first day of the Republican year as a DateTime object.

```php
var Floreal = require('floreal').Date;
echo (new FlorealDate(8, 11, 9))->first_day_of_year()->format("c"));
echo (new FlorealDate(11, 8, 18))->first_day_of_year()->format("c"));
```
will output:

    Mon Sep 23 1799
    Thu Sep 23 1802

### FlorealDate::republican_day_of_year() ###
Returns the day number within the year (from 1 to 365, or 366 for sextile years).

```php
echo (new FlorealDate(8, 11, 9))->republican_day_of_year();
```
will output:

    309

### FlorealDate::republican_month() ###
Returns the month number within the year. Complementary days are technically not part of any month, but for practical purposes are considered part of the 13th month.

```php
echo (new FlorealDate(8, 11, 9))->republican_month();
```
will output:

    11

### FlorealDate::is_complementary_day() ###
Whether the day is a complementary day&mdash;the five or six days at the end of the year which are not part of any month.

```php
echo (new FlorealDate(8, 11, 9))->is_complementary_day();
echo (new FlorealDate(8, 13, 1))->is_complementary_day();
```
will output:

    false
    true

### FlorealDate::republican_month_name() ###
Returns the (French) name of the month, in all lower case, or 'sans-culottide' for complementary days.

```php
echo (new FlorealDate(strtotime("1799-11-09")))->republican_month_name();
echo (new FlorealDate(strtotime("1800-09-20")))->republican_month_name();
```
will output:

    "brumaire"
    "sans-culottide"

### FlorealDate::republican_day() ###
Returns the day number within its month, from 1 to 30 (1 to 6 for complementary days).

```php
echo (new FlorealDate(strtotime("1799-11-09")))->republican_day();
echo (new FlorealDate(strtotime("1800-09-20")))->republican_day();
```
will output:

    18
    3

### FlorealDate::day_of_decade() ###
Returns the day number within its decade, from 1 to 10 (1 to 6 for complementary days).

```php
echo (new FlorealDate(strtotime("1799-11-09")))->republican_day_of_decade();
echo (new FlorealDate(strtotime("1800-09-20")))->republican_day_of_decade();
```
will output:

    8
    3

### FlorealDate::republican_day_name() ###
Returns the name of the day (primidi, duodi... equivalent to monday, tuesday...). Complementary days have a different naming scheme and are named "jour de la vertu", "jour du génie", etc.

```php
echo (new FlorealDate(strtotime("1799-11-09")))->republican_day_name();
echo (new FlorealDate(strtotime("1800-09-20")))->republican_day_name();
```
will output:

    octidi
	jour du travail

### FlorealDate::republican_day_title() ###
Returns the French name of the object associated with the day (like saints on Christian calendars).

```php
echo (new FlorealDate(strtotime("1799-11-09")))->republican_day_title();
```
will output:

    dentelaire
