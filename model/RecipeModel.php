<?php 


class RecipeModel
{
	
	function __construct()
	{
		$this->db = new Database();
	}

	public function create($title, $description, $recipe, $userId, $categoryId, array $ingredients)
    {
       
        // Insertion de la commande dans la base de donées.
        $recipeId = $this->db->executeSql('
        	INSERT INTO recipe
			(title, description, recipe, created_at, user_id, category_id) 
			VALUES 
			(:title, :description, :recipe, :created_at, :userId, :categoryId)
		', [ 
			':title' 		=> $title,
			':description' 	=> $description,
			':recipe' 		=> $recipe,
			':created_at'	=> date_create()->format('Y-m-d H:i:s'),
			':userId' 		=> $userId,
			':categoryId'	=> $categoryId,
        ]);

        $sql = '
        	INSERT INTO ingredient
        	(name, quantity, recipe_id)
        	VALUES
        	(?, ?, ?)
        ';

        foreach ($ingredients as $ingredient) {
            
            $this->db->executeSql($sql, [
                $ingredient['name'],
                $ingredient['quantity'],
               	$recipeId
            ]);
        }
    }

    public function delete($recipeId)
    {
    	$sql = '
	    	DELETE FROM recipe
    		WHERE id = :recipeId
    	';
 
    	$this->db->executeSql($sql, [
			':recipeId' => $recipeId
        ]);
    }

    public function edit($recipeId, $title, $description, $recipe, $categoryId, array $ingredients)
    {
    	$sql = '
	    	UPDATE recipe
	    	SET title = :title,
	    		description = :description,
	    		recipe = :recipe,
	    		category_id = :categoryId

    		WHERE id = :recipeId
    	';
 
    	$this->db->executeSql($sql, [
			':recipeId'  	=> $recipeId,
			':title'	 	=> $title,
			':description'  => $description,
			':recipe'	 	=> $recipe,
			':categoryId'	=> $categoryId
        ]);

        // Supression des anciens ingredients
        $sql = '
	    	DELETE FROM ingredient
    		WHERE recipe_id = :recipeId
    	';
 
    	$this->db->executeSql($sql, [
			':recipeId' => $recipeId
        ]);

        $sql = '
        	INSERT INTO ingredient
        	(name, quantity, recipe_id)
        	VALUES
        	(?, ?, ?)
        ';

        foreach ($ingredients as $ingredient) {
            
            $this->db->executeSql($sql, [
                $ingredient['name'],
                $ingredient['quantity'],
               	$recipeId
            ]);
        }
    }

    public function findById($id)
    {
    	$sql = ('
    		SELECT 
    			recipe.id,
    			title,
    		    description,
    		    recipe,
    		    recipe.created_at,
    		    recipe.checked,
    		    category_id,
    		    user.firstname,
    		    user.lastname
			FROM recipe 
			INNER JOIN category ON recipe.category_id = category.id
			INNER JOIN user ON recipe.user_id = user.id
			WHERE recipe.id = :id 
		');

		return $this->db->queryOne($sql, [ 
			':id' => $id
        ]);
    }

    public function findByTitle($title)
    {
    	$sql = ('
    		SELECT 
    			recipe.id,
    			title,
    		    description,
    		    recipe,
    		    recipe.created_at,
    		    recipe.checked,
    		    category_id,
    		    user.firstname,
    		    user.lastname
			FROM recipe 
			INNER JOIN category ON recipe.category_id = category.id
			INNER JOIN user ON recipe.user_id = user.id
			WHERE title = :title 
		');

		return $this->db->queryOne($sql, [ 
			':title' => $title
        ]);
    }

    public function findByValidateId($id)
    {
    	$recipe = $this->db->queryOne('
    		SELECT 
				title,
			    description,
			    recipe,
			    recipe.created_at,
			    user.firstname,
			    user.lastname
			FROM recipe 
			INNER JOIN category ON recipe.category_id = category.id
			INNER JOIN user ON recipe.user_id = user.id
			WHERE recipe.id = ? AND recipe.checked = "ok"
		', [$id]);

		// Si la recette n'existe pas, création d'une exeption
		if (empty($recipe)) {
		    throw new Exception(
		        'Désolé cette recette n\'existe pas encore !'
		    );
		}

		return $recipe;

    }

	public function getByCategory($categoryId)
		{
			$sql = ('
				SELECT 
					recipe.id,
					title,
				    description,
				    user_id,
				    category_id,
				    category.name,
				    category.photo,
				    user.firstname,
				    user.lastname
				FROM recipe 
				INNER JOIN category ON recipe.category_id = category.id
				INNER JOIN user ON recipe.user_id = user.id
				WHERE recipe.checked = "ok" AND category_id = :categoryId
				ORDER BY recipe.id DESC
				LIMIT 8
			');

			return $this->db->query($sql, [ 
						':categoryId' => $categoryId
			        ]);
	}

	public function getByLastId($id)
	{
		$sql = ('
			SELECT 
				recipe.id,
				title,
			    description,
			    category_id,
			    category.photo,
			    user.firstname,
			    user.lastname
			FROM recipe 
			INNER JOIN category ON recipe.category_id = category.id
			INNER JOIN user ON recipe.user_id = user.id
			WHERE recipe.checked = "ok" AND recipe.id < :id
			ORDER BY recipe.id DESC
            LIMIT 8
		');

		return $this->db->query($sql, [ 
			':id' => $id
        ]);
	}

	public function getByLastIdAndCategory($id, $category)
	{
		$sql = ('
			SELECT 
				recipe.id,
				title,
			    description,
			    category_id,
			    category.name,
			    category.photo,
			    user.firstname,
			    user.lastname
			FROM recipe 
			INNER JOIN category ON recipe.category_id = category.id
			INNER JOIN user ON recipe.user_id = user.id
			WHERE recipe.checked = "ok" AND recipe.id < :id AND category_id = :category
			ORDER BY recipe.id DESC
            LIMIT 8
		');

		return $this->db->query($sql, [ 
			':id' => $id,
			':category' => $category
        ]);
	}

	public function getCategoryList()
	{
		$sql = ('
			SELECT 
				id, 
				name, 
				photo
			FROM category 
			ORDER BY name');

		return $this->db->query($sql);
	}

    public function getIngredients($recipeId)
    {
    	$sql = ('
    		SELECT 
    			id,
    			name, 
    			quantity
    		FROM ingredient 
    		WHERE `recipe_id` = :recipeId
		');

		return $this->db->query($sql, [ 
			':recipeId' => $recipeId
        ]);
    }

	public function getLastests()
	{
		$sql = ('
			SELECT 
				recipe.id,
				title,
			    description,
			    category.photo,
			    user.firstname,
			    user.lastname
			FROM recipe 
			INNER JOIN category ON recipe.category_id = category.id
			INNER JOIN user ON recipe.user_id = user.id
			WHERE recipe.checked = "ok"
			ORDER BY recipe.id DESC
			LIMIT 8
		');

		return $this->db->query($sql);
	}

	public function getToValidate()
	{
		$sql = ('
			SELECT 
				recipe.id,
				title,
			    description,
			    recipe.created_at,
			    user.firstname,
			    user.lastname
			FROM recipe 
			INNER JOIN category ON recipe.category_id = category.id
			INNER JOIN user ON recipe.user_id = user.id
			WHERE recipe.checked IS NULL
			ORDER BY recipe.id DESC
		');

		return $this->db->query($sql);
	}

    public function validate($recipeId)
    {
    	$sql = ('
    		UPDATE recipe
    		SET checked = "ok"
    		WHERE id = :recipeId
    	');
    	    
    	$this->db->executeSql($sql, [
			':recipeId' => $recipeId
        ]);
    }

}