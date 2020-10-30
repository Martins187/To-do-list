<?php
    include 'Record.php';
    include 'Validation.php';

   if(isset($_POST['add_record'])){
    
        $input = $_POST['add_record'];
        
        if(validate($input)===true){
            $newRecord = new Record($input);
            $newRecord->addRecord(); 
        }   
        else{
            echo 'Invalid characters in the record!';
        }
    }
    else if(isset($_POST['edit_record'])){

        $newRecord = $_POST['edit_record'];

        if(validate($newRecord)===true){
            $id = $_POST['iD'];
            $record = new Record('');
            $record->setRecord($newRecord);
            $record->editRecord($id);
        }
        else{
            echo 'Invalid characters for the new record!';
        }
    }
    else if(isset($_POST['operation'])){

        if($_POST['operation'] === 'delete'){
            $deletion = new Record('');
            $deletion->deleteRecords();
        }
        else if($_POST['operation'] === 'mark'){
            $marking = new Record('');
            $marking->markRecords();
        }
        else{
            $clear = new Record('');
            $clear->clearRecords();
        }  
    }
    else{
        $show = new Record('');
        $show->show();
    }
?>

