<?php
    include 'Connection.php';
    
    class Record extends Connection{
        private $record;
        
        public function __construct($record){
            $this->record = $record;
        } 
        public function setRecord($newRecord){
            $this->record = $newRecord;
        }
        public function addRecord(){

            $add ="INSERT INTO records (`Record`) 
            VALUES ('$this->record')";
        
            if (mysqli_query($this->connect(), $add)) {
                echo 'Record added successfully';
            }
            else{
                echo "Error creating a record: " . mysqli_error($conn);
            }
        }
        public function editRecord($id){
            $add ="UPDATE records SET Record = '$this->record' WHERE Id = $id";
        
            if (mysqli_query($this->connect(), $add)) {
                echo 'Success';
            }
            else{
                echo "Error editing a record: " . mysqli_error($this->connect());
            }
        }
        public function show(){

            $sql = "SELECT * FROM records";
            $result = $this->connect()->query($sql);
            $numRows = $result->num_rows;
            if($numRows > 0){
                while($row = $result->fetch_assoc()){
                    $data[] = $row;
                }
                foreach($data as $record){
                    echo '<div id = "'.$record["Id"].'" class = "bloks ';
                    if ($record["IsActive"] == 0){
                        echo 'completed" ';
                    }
                    else{
                        echo 'uncompleted" ';
                    }  
                    echo 'style = "background-color: rgb(186, 202, 245);">';
                    ?>
                    <div class = "bloks2">
                    <?php
                        echo $record['Record']."<br><br>";
                        echo '</div>';
                       ?>
                     <input type = "checkbox" class = "button" name = "checked_records[]" value = "<?php echo $record["Id"];?>"/>
                     <?php
                     echo'</div>';  
                }
            }
            else{
                echo 'No records added yet';
            }
        }
        public function deleteRecords(){
            
            $box = $_POST['checked_records'];

            foreach($box as $value){
                $del = "DELETE FROM records WHERE Id= $value";
                if (!mysqli_query($this->connect(), $del)) {
                    echo "Error deleting record: " . mysqli_error($this->connect());  
                }
            }
        }
        public function markRecords(){
            
            $box = $_POST['checked_records'];

            foreach($box as $value){
                $mark = "UPDATE records SET IsActive = 0 WHERE Id = $value";
                
                if (!mysqli_query($this->connect(), $mark)) {
                    echo "Error marking the record: " . mysqli_error($this->connect());
                }
            }
        }
        public function clearRecords(){

            $data = $_POST['completed'];
 
            foreach($data as $record){
                $del = "DELETE FROM records WHERE Id= $record";
                $query = mysqli_query($this->connect(), $del);
            }
            echo 'All clear!';                     
        }    
    }
?>