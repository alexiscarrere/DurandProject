# DurandProject

La société DURAND SAS a besoin d’une API RESTFUL sécurisée permettant de gérer la base de
données de machines outils :
Cette API décode des données en JSON pour en renvoyer.

## Comment l'utiliser ?

Pour l'utiliser, après avoir crée une bdd dans un .env.local et grầce à la commande bin/console d:d:c, lancez un serveur avec symfony serve -d. Inscrivez vous via la route /register (POST) en envoyant en JSON un username et un password. Une fois l'inscription confirmée, vous devez obtenir un JWT token en envoyant vos informations de connexion en POST à la route /api/login_check. Copier-collez ce jeton, vous en aurez besoin pour toutes vos actions.

Les routes disponibles sont :

- /api/machineOutil : CREATE (POST) : En envoyant des données telles que le nom et la description, une machineOutil sera créée.
- /api/machineOutil/{/id} : READ (GET) : Vous pourrez lire les informations de VOTRE machineOutil. Si vous essayez de lire une machine qui ne vous appartient pas, erreur.
- /api/machineOutil/{id} : UPDATE (PATCH) : En envoyant des données telles que le nom et la description, la machineOutil ayant pour id l'id sélectionné sera modifiée.
- /api/machineOutil/{id} : DELETE (DELETE) : Supprimez une machineOutil vous appartenant.

Pour utiliser ces routes, vous devrez envoyer en Header : "Authorization" : "Bearer (Jeton précédemment obtenu)"


Une machine outil est composée des éléments suivants :
- un id,
- un nom,
- une description,
- et une liaison à un utilisateur (un utilisateur peut avoir plusieurs machines mais machine n’a
qu’un utilisateur)
