<?php

class authorization {
    public static function register($username, $password, $email)   // register method, return is for error message if something dosent work
    {

        if (!DB::query('SELECT username FROM users WHERE username=:username', array(':username'=>$username))) { // if username dosent exists in database

            if (strlen($username) >= 3 && strlen($username) <= 32) {    // rules for the username

                    if (preg_match('/[a-zA-Z0-9_]+/', $username)) { // check so no other characters are used than a-z and 0-9

                            if (strlen($password) >= 6 && strlen($password) <= 60) {    // rules for the password

                            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {    // validating email so it isnt invalid

                            if (!DB::query('SELECT email FROM users WHERE email=:email', array(':email'=>$email))) {    // checking so email isnt already in use

                                    // if all checks out insert into db
                                    DB::query('INSERT INTO users VALUES (\'\', :username, :password, :email, \'0\', \'\', \'\')', array(':username'=>$username, ':password'=>password_hash($password, PASSWORD_BCRYPT), ':email'=>$email));
                                    return "<p id='error'style='color:green'>Registration Successful</p>";
                            } else {
                                return "<p id='error'style='color:red'>Email already in use!</p>";
                            }
                    } else {
                        return "<p id='error'style='color:red'>Invalid Email!</p>";
                            }
                    } else {
                        return "<p id='error'style='color:red'>Invalid Password (a-z, 0-9) > 6 && 30 < </p>";
                    }

                    } else {
                        return "<p id='error'style='color:red'>Invalid Username (a-z, 0-9) </p>";
                    }
            } else {
                return "<p id='error'style='color:red'>Invalid Username length, minimum 3 and maximum 32 </p>";
            }

    } else {
        return "<p id='error'style='color:red'>Username Already Taken! </p>";
    }
    }

    public static function login($username, $password)  // login method
    {
        if(DB::query('SELECT username FROM users WHERE username=:username', array(':username'=>$username))) // check if username exists
        {
           // Grabing password from the username to compare if it is correct
          if(password_verify($password, DB::query('SELECT password FROM users WHERE username=:username', array(':username'=>$username))[0]['password']))   // checks if password matches
          {
            $cstrong = true;
            $token = bin2hex(openssl_random_pseudo_bytes(64, $cstrong));
            $user_id = DB::query('SELECT id FROM users WHERE username=:username', array(':username'=>$username))[0]['id'];
            DB::query('INSERT INTO login_tokens VALUES (\'\', :token, :user_id)', array('token'=>sha1($token), ':user_id'=>$user_id));
           setcookie("CMBNID", $token, time() + 60 * 60 * 24 * 7, '/', NULL, NULL, TRUE); // cookies so u wont logout when exiting page
           Redirect::goto('index.php');
          }
          else
          {
            return "<p id='error'style='color:red'>Wrong Credentials!</p>";
          }
        } else
        {
            return "<p id='error' style='color:red'>Wrong Credentials!</p>";
        }
    }


    public static function ValidateAdmin($id)   // check if user is admin, bool 
    {
        if(DB::query('SELECT user_id FROM administrator WHERE user_id=:userid', array(':userid'=>$id)))
        { 
           return true;
        }
        else
        { 
            return false;
        }
    }

    // deprecated but good to have as backup if js api wont work
    public static function CommentDelete($id)   
    {
        DB::query('DELETE FROM comments WHERE id=:cmtID',array(':cmtID'=>$id));  // deleting comments associated with the post
    }

    public static function AdminDeleteComment($id)
    {
        DB::query('DELETE FROM comments WHERE id=:cmtID',array(':cmtID'=>$id));  // deleting comments associated with the post
    }

    public static function AdminDeletePost($id)
    {
        if(DB::query('SELECT id FROM posts WHERE id=:postid', array(':postid'=>$id))) // selecting the post
        {
          DB::query('DELETE FROM comments WHERE post_id=:postid',array(':postid'=>$id));  // deleting comments associated with the post
          DB::query('DELETE FROM posts WHERE id=:A_POSTID',array(':A_POSTID'=>$id));  // deleting the post
          DB::query('DELETE FROM post_likes WHERE post_id=:A_POSTID',array('A_POSTID'=>$id)); //deleting the post likes
        }
    }
}
