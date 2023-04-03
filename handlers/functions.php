<?php
    include './data/uni_options.php';
    //Connect to database
    $connect = mysqli_connect("localhost","root","","basics");

    // gather student's data from table student
    function query($query)
    {
        global $connect;
        $result = mysqli_query($connect,$query);
        $rows = [];
        while ($row = mysqli_fetch_assoc($result))
        {
            $rows[] = $row;
        }
        return $rows;
    }

    // query insert data
    function add($data)
    {
        global $universities;
        global $connect;
        
        $nim = htmlspecialchars($data["nim"]);;
        $nama = htmlspecialchars($data["nama"]);
        $prodi = htmlspecialchars($data["prodi"]);
        $email = htmlspecialchars($data["email"]);

        //checking if university exist
        $gambar = htmlspecialchars($data["gambar"]); 
        if(!in_array($gambar,$universities))
        {
            return 
            "<h3>Failed!</h3><br>".
            "<h4>University doesn't exist!</h4><br>".
            "<h4>Please contact customer support</h4><br>";
            "<h4>To verify your university</h4><br>";
        }
        $gambar = "".$gambar.".png";

        $query = "INSERT INTO student VALUES('','$nama','$nim','$prodi','$email','$gambar')";
        mysqli_query($connect,$query);

        // return status 
        $isSuccess = mysqli_affected_rows($connect) > 0;
        if($isSuccess)
        {
            return 
            "<h3>Success!</h3><br>".
            "<h4>Data has been successfully added to database!</h4><br>";
        }
        return 
        "<h3>Failed!</h3><br>".
        "<h4>Data failed to add to database!</h4><br>";
    }

    function delete($id)
    {
        global $connect;
        mysqli_query($connect,"DELETE FROM student WHERE id = $id");
        return mysqli_affected_rows($connect);
    }

    function update($id, $data)
    {
        global $connect;
        global $universities;
        
        $nim = htmlspecialchars($data["nim"]);;
        $nama = htmlspecialchars($data["nama"]);
        $prodi = htmlspecialchars($data["prodi"]);
        $email = htmlspecialchars($data["email"]);

        //checking if university exist
        $gambar = htmlspecialchars($data["gambar"]); 
        if(!in_array($gambar,$universities))
        {
            return 
            "<h3>Failed!</h3><br>".
            "<h4>University doesn't exist!</h4><br>".
            "<h4>Please contact customer support</h4><br>";
            "<h4>To verify your university</h4><br>";
        }
        $gambar = "".$gambar.".png";

        $query = "UPDATE student
        SET nim = '$nim', 
        nama = '$nama', 
        prodi = '$prodi',
        email = '$email',
        gambar = '$gambar'
        WHERE id = $id";

        mysqli_query($connect,$query);

        $isSuccess = mysqli_affected_rows($connect) > 0;
        if($isSuccess)
        {
            return 
            "<h3>Success!</h3><br>".
            "<h4>Data has been successfully added to database!</h4><br>";
        }
        return 
        "<h3>Failed!</h3><br>".
        "<h4>Data failed to add to database!</h4><br>";
    }

    function getData($query)
    {
        global $connect;
        $result = mysqli_query($connect,$query); 

        //check if data exist or not
        if(mysqli_num_rows($result) > 0)
        {
            return mysqli_fetch_assoc($result);    
        } 
        return NULL;
    }

    function search($keyword)
    {
        $query = "SELECT * FROM student 
        WHERE nama LIKE '%$keyword%' OR
        nim LIKE '%$keyword%' OR
        email LIKE '%$keyword%' OR
        prodi LIKE '%$keyword%' OR
        gambar LIKE '%$keyword%'";
        return query($query);
    }

    function filterExtension($string, $extension)
    {
        return substr($string,0,strrpos($string,$extension));
    }
?>