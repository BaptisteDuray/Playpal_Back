---  ETAPE 01 findAll-- 

Pour cette première étape on va voir comment  récupérer les infos de la base de données et l'afficher côté front grace au Json (language qui permet de communiquer entre les technos)

Pour cela on va créer notre contrôleur que l'on range dans un dossier API. (ps : coter symfo nous avons un commande dans le terminal "php bin/console make:controller" qui nous permet de créer notre controlleur) 

1. #[Route('api/category', name: 'app_api_category')]
Voilà notre route générale qui va s'appliquer sur toutes nos prochaines routes. Elle se place avant notre classe. Elle est composé d'une URL pour le navigateur et d'un nom pour appeler dans notre code

2. #[Route('/', name: 'browse', methods:"GET")]
Puis on fait une route pour chaque fonction que l'on veut faire. la route URL et le nom vont se rajouter à la route principale et l'on rajoute ici une méthode. (GET est la méthode pour afficher des infos)

3. public function browse(CategoryRepository $categoryRepo): JsonResponse

Ensuite nous créons notre fonction qui va contenir notre code. 

**CategoryRepository** va nous permettre d'exécuter des requêtes préparer dans notre entité (ou table) category  

Et l'on indique **JsonResponse** pour précise que notre requête est en Json

4. $categoryAllList = $categoryRepo -> findAll();

Cette ligne de code nous permet d'exécuter la requête findAll() dans category pour remonter toutes les informations des catégories

5.  return $this->json($categoryAllList,  Response::HTTP_OK, [], ['groups' => 'game_browse']);

Pour finir on retourne le résulta en json. 

 **Response::HTTP_OK** renvoie la réponse correspondant à notre requête pour dire que tout est bon 

 **[]** on doit toujours renvoyer un tableau vide

 **['groups' => 'game_browse']** Pour renvoyer les infos que l'on veut retourner on créé des groupes dans nos entités et après il suffit de les appelés. 

 (Exemple de groupe dans les Entités  :
    #[ORM\Column(length: 255)]
    #[Groups(['game_browse', 'category_browse','rent_browse'])]
    private ?string $Name = null;
 )



 ---  ETAPE 02 find--

 En reprenant notre exemple plus haut, on va maintenant trouver les informations d'une catégorie bien précise en utilisant sont ID

1. #[Route('/{id<\d+>}', name: 'read', methods:"GET")]

on crée notre route en indiquant qu'il y aura une ID dans l'URL (Elle est notée en reg ex pour que l'URL comprend) et toujours en méthode GET

2. public function read(int $id, CategoryRepository $categoryRepo): JsonResponse

dans notre fonction par rapport à un findall on rajoute $id et int 

3. $categoryGameList = $categoryRepo -> find($id);

On exécute la fonction find et l'on utilise l'id des catégories  pour trouvé celle que l'on veut

4.  if (is_null($categoryGameList))
        {
            return $this->categoryNotFound();
        }

    private function categoryNotFound()
    {

    $data = [
            "success" => false,
            "message" => "category not found"
        ];

        return $this->json($data, Response::HTTP_NOT_FOUND)
    }

on rajoute une condition pour retourner une fonction qui va afficher un message si notre requête ne trouve pas l'ID  

5. return $this->json($categoryGameList,  Response::HTTP_OK, [], ['groups' => 'category_browse'])

Puis comme pour le findall on retourne nos infos demander et notre requête qui indique que tout est Ok.




 ---  ETAPE 03 Tokken JWT--

1. Tous d'abord nous allons intaller notre Tokken (**Attention c'est l'installation coté symfo**) :

Pour commencer lancer la commande "php composer.phar require "lexik/jwt-authentication-bundle"" pour installer le tokken dans votre code

2. Ensuite on génére notre clé avec la commande "php bin/console lexik:jwt:generate-keypair" **Attention il faudra générer toujours générer la clé**

3. copier ce code :

 login:
            pattern: ^/api/login
            stateless: true
            json_login:
                check_path: /api/login_check
                success_handler: lexik_jwt_authentication.handler.authentication_success
                failure_handler: lexik_jwt_authentication.handler.authentication_failure

        api:
            pattern:   ^/api
            stateless: true
            jwt: ~

et coller ce code dans **security.yaml** dans **firewalls**




