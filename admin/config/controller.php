<?php

// query select data
function query($query)
{
    global $conn;

    $result = mysqli_query($conn, $query);
    $rows = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }

    return $rows;
}

// create category
function store_category($data)
{
    global $conn;

    $title  = sanitize($data['title']);
    $slug   = sanitize($data['slug']);

    $stmt = $conn->prepare("INSERT INTO categories (title, slug) VALUES (?, ?)");
    $stmt->bind_param("ss", $title, $slug);
    $stmt->execute();

    return $stmt->affected_rows;
}

// delete category
function delete_category($id)
{
    global $conn;

    $query = "DELETE FROM categories WHERE id_category = $id";
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

// update category
function update_category($data)
{
    global $conn;

    $id_category    = (int)$data['id_category'];
    $title          = sanitize($data['title']);
    $slug           = sanitize($data['slug']); 

    $stmt = $conn->prepare("UPDATE categories SET title = ?, slug = ? WHERE id_category = ?");
    $stmt->bind_param("ssi", $title, $slug, $id_category);
    $stmt->execute();

    return $stmt->affected_rows;
}

// store film
function store_film($data)
{
    global $conn;

    $title          = sanitize($data['title']);
    $slug           = sanitize($data['slug']);
    $category       = sanitize($data['category']);
    $description    = sanitize($data['description']);
    $studio         = sanitize($data['studio']);
    $release_date   = sanitize($data['release_date']);
    $visibility     = sanitize($data['visibility']);
    $url            = sanitize($data['url']);

    $stmt = $conn->prepare("INSERT INTO films (title, slug, category_id, description, studio, release_date, is_private, url) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssisssis", $title, $slug, $category, $description, $studio, $release_date, $visibility, $url);
    $stmt->execute();
    
    return $stmt->affected_rows;
}

// delete film
function delete_film($id)
{
    global $conn;

    $stmt = $conn->prepare("DELETE FROM films WHERE id_film = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    return $stmt->affected_rows;
}

// update film
function update_film($data)
{
    global $conn;

    $id_film        = (int)$data['id_film'];
    $title          = sanitize($data['title']);
    $slug           = sanitize($data['slug']);
    $category       = sanitize($data['category']);
    $description    = sanitize($data['description']);
    $studio         = sanitize($data['studio']);
    $release_date   = sanitize($data['release_date']);
    $visibility     = sanitize($data['visibility']);
    $url            = sanitize($data['url']);   

    $stmt = $conn->prepare("UPDATE films SET title = ?, slug = ?, category_id = ?, description = ?, studio = ?, release_date = ?, is_private = ?, url = ? WHERE id_film = ?");
    $stmt->bind_param("ssisssisi", $title, $slug, $category, $description, $studio, $release_date, $visibility, $url, $id_film);
    $stmt->execute();

    return $stmt->affected_rows;
}

// store user
function store_user($data)
{
    global $conn;

    $username       = sanitize($data['username']);
    $email          = sanitize($data['email']);
    $role          = sanitize($data['role']);
    $password       = sanitize(password_hash($data['password'], PASSWORD_DEFAULT));
    
    $stmt = $conn->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $email, $password, $role);
    $stmt->execute();
    
    return $stmt->affected_rows;
}

// delete user
function delete_user($id)
{
    global $conn;

    $stmt = $conn->prepare("DELETE FROM users WHERE id_user = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    
    return $stmt->affected_rows;
}

// update user
function update_user($data)
{
    global $conn;

    $id_user        = (int)$data['id_user'];
    $username       = sanitize($data['username']);
    $email          = sanitize($data['email']);
    $role           = sanitize($data['role']);
    $password       = sanitize($data['password']);

    if (empty($password)) {
        if ($_SESSION['role'] != 'admin') {
            $stmt = $conn->prepare("UPDATE users SET username = ?, email = ? WHERE id_user = ?");
            $stmt->bind_param("ssi", $username, $email, $id_user);
        } else {
            $stmt = $conn->prepare("UPDATE users SET username = ?, email = ?, role = ? WHERE id_user = ?");
            $stmt->bind_param("sssi", $username, $email, $role, $id_user);
        }
    } else {
        $password = password_hash($password, PASSWORD_DEFAULT);
        if ($_SESSION['role'] != 'admin') {
            $stmt = $conn->prepare("UPDATE users SET username = ?, email = ?, password = ? WHERE id_user = ?");
            $stmt->bind_param("sssi", $username, $email, $password, $id_user);
        } else {
            $stmt = $conn->prepare("UPDATE users SET username = ?, email = ?, password = ?, role = ? WHERE id_user = ?");
            $stmt->bind_param("ssssi", $username, $email, $password, $role, $id_user);
        }
    }
    
    $stmt->execute();
    
    return $stmt->affected_rows;
}
