# downloader

#### Cli reference

`php artisan download:results | column -t` - check results

`php artisan download:add {url}` - Put url to queue

`php artisan queue:work` - Start queue processing
 
#### API reference

Endpoint | Request | Keys | Description
--------- | ----------- | -------| -------
| `/api/download/results` | GET | - | check results
| `/api/download/add` | POST | url (string) | Put url to queue
