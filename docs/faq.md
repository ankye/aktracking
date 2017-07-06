#FAQ
## 1. Where is Gii?
Gii is available on:
- http://aktracking.dev/gii
- http://backend.aktracking.dev/gii

## 2. How do i enable email activation?
Edit ``frontend/config/web.php`` and set [[frontend\modules\user\Module::shouldBeActivated]] property to ``true``

## 3. How do i access mailcatcher?
In docker installation mailcatcher is running on [aktracking.dev:1080](aktracking.dev:1080)

## 4. How do i open application cli when run application in docker?
Run this command in project directory:
```
docker exec -it $(docker-compose ps -q cli) bash
```