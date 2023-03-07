<?php

namespace Rmunate\ArtisanUtilities;

class Git
{
    
    /* Mensaje cuando no hayan cambios en la Rama */
    const DEFAULT_COMMENT_WITHOUT_CHANGES = 'Registro Sin Cambios En El Proyecto.';

    /* Mensaje Previo a la lista de cambios del proyecto */
    const TEXT_BEFORE_CHANGED_FILES = 'Archivo(s) Actualizado(s): ';

    /* Texto previo a cada nombre de archivo modificado */
    const TEXT_BEFORE_FILE_CHANGED = 'Archivo Con Cambios #';

    /* Mensaje cuando no se registren cambios desde el anterior commit */
    const WITHOUT_CHANGES = 'No Registran Cambios Desde El Último -Commit-';

    /* Textos a excluid al sanear el arreglo de ramas */
    const BRANCHES_CHARACTERS = [
        "* ",
        "\n  master\n  ",
        "HEAD -> origin/master\n  ",
        "\n  main\n  ",
        "HEAD -> origin/main\n  ",
        "\n  ",
        "\n"
    ];

    /* Lineas a Excluir del status */
    const OMIT_LINES_CONTAINING = [
        'En la rama',
        'Tu rama est',
        'no rastreados',
        'git add',
        'no changes added',
        'Changes not staged',
        'sin cambios',
        'Cambios a ser',
        'git restore',
        'git push',
        'commit'
    ];

    /* Consulta de Ramas Remotas Proyecto */
    public static function branches(){
        return shell_exec('git branch -a');
    }

    /* Limpiar Arreglo de Ramas */
    public static function fixBranches(array $arrayRamas){
        $array_ramas = [];
        foreach ($arrayRamas as $rama) {
            $str_out = str_replace(Self::BRANCHES_CHARACTERS,'', $rama);
            if (!empty($str_out)) {
                array_push($array_ramas,$str_out);
            }
        }
        $array_ramas = array_unique($array_ramas);
        return $array_ramas;
    }

    /* Validacion De Rama */
    public static function validateBranch(string $rama){
        $ramasFinal = Self::fixBranches(explode('remotes/origin/' , Self::branches()));
        return ($ramasFinal[0] == $rama) ? 
            (object) [
                'validate' => true,
                'name' => $ramasFinal[0]
            ] : (object) [
                'validate' => false,
                'name' => $ramasFinal[0]
            ];
    }

    /* Validar si contiene caracteres para omitir */
    public static function line_contains($str){
        $contains = 0;
        foreach (Self::OMIT_LINES_CONTAINING as $value) {
            if (str_contains($str, $value)){
                $contains++;
            }
        }
        return ($contains == 0) ? true : false;
    }
    
    /* Status */
    public static function status(){

        /* Retorna las lineas de GitStatus */
        $status = shell_exec('git status');
        
        /* Convertir en arreglo */
        $status = explode("\n", $status);
    
        /* Eliminar Filas Vacias*/
        $data = [];
        if (count($status) > 0) {
            $i = 1;
            foreach ($status as $one) {
                if (($one != "") && Self::line_contains($one)) {
                    $one = str_replace(["\t", ' '],"", $one);
                    $one = str_replace(":"," : ", $one);
                    $one = str_replace("modificados", Self::TEXT_BEFORE_FILE_CHANGED . $i, $one);
                    $i++;
                    array_push($data, $one);
                }
            }
        } else {
            array_push($data, Self::WITHOUT_CHANGES);
        }

        return $data;

    }

    /* Add */
    public static function add(){
        /* Agregar Todos los Cambios Locales */
        return shell_exec('git add .');
    }

    /* Commit */
    public static function commit(string $comentarioCommit){
        return shell_exec('git commit -m "' . $comentarioCommit . '"');
    }

    /* Comentario Por Defecto de no agregarse */
    public static function default_comment($array){
        if((count($array) > 0) && ($array[0] != Self::WITHOUT_CHANGES)){
            $data = [];
            foreach ($array as $key => $value) {
                $linea = explode(" : ", $value)[1];
                array_push($data, $linea);
            }
            $data = implode(', ', $data);
            return Self::TEXT_BEFORE_CHANGED_FILES . $data;
        } else {
            return Self::DEFAULT_COMMENT_WITHOUT_CHANGES;
        }
    }

    /* Ramas Diferentes a la Que esta En Uso  */
    public static function getAllBranches(){
        return Self::fixBranches(explode('remotes/origin/' , Self::branches()));
    }

    /* Ramas Diferentes a la Que esta En Uso  */
    public static function getOtherBranches(){
        $branches =  Self::fixBranches(explode('remotes/origin/' , Self::branches()));
        unset($branches[0]);
        return $branches;
    }

    /* Pull Origin Remoto */
    public static function pull(string $rama){
        return shell_exec('git pull origin ' . $rama);
    }

    /* Push */
    public static function push(string $rama){
        return shell_exec('git push origin ' . $rama);
    }

    /* Historico Commits */
    public static function commits(){
        $commits = (shell_exec('git log --oneline'));
        $arrayCommits = explode("\n" , $commits);
        $arrayCommits = array_unique($arrayCommits);
        unset($arrayCommits[count($arrayCommits) - 1]);
        return $arrayCommits;
    }

    /* Ajuste Logs */
    public static function logs($cantidad = null, $largo_max = 150){

        // Recorriendo Array para sanear el [\t]
        $arrayCommitsList = [];

        foreach (Self::commits() as $commit) {
            $ajuste =  str_replace("\t", "", $commit);
            /* Ajustar Largo */
            if (strlen($ajuste) > $largo_max) {
                array_push($arrayCommitsList, substr($ajuste, 0, $largo_max) . '...');
            } else {
                array_push($arrayCommitsList, $ajuste);
            }
        }

        $arrayCommitsList = array_unique($arrayCommitsList);

        if (!empty($cantidad)) {
            $arrayCommitsList = array_slice($arrayCommitsList, 0, $cantidad);
            return $arrayCommitsList;
        }

        return $arrayCommitsList;
    }

    /* Detalle Del Cambio */
    public static function show(string $cambio){
        // Conocer el autor y fecha de carga.
        $showCommit = (shell_exec('git show '. $cambio));
        // Generando un array de los commits
        $arrayShowCommits = explode("\n" , $showCommit);
        //Extraer Los Datos Relevantes
        $show = array_slice($arrayShowCommits, 0, 3);
        //Limpiar Cuerpo
        $cuerpo = array_slice($arrayShowCommits, 3, 100);
        $body = [];
        foreach ($cuerpo as $key => $value) {
            if(!empty($value)){
                $array_str = explode(' ', $value);
                $array_str = array_unique($array_str);
                $array_to_str = implode(' ', $array_str);
                array_push($body, trim($array_to_str));
            }
        }
        $cuerpo = 'Detalle Cambio: ' . implode(' | ',$body);
        array_push($show, $cuerpo);
        return $show;
    }

    /* Git Reset */
    public static function reset(string $cambio){
        return shell_exec('git reset --hard '. $cambio);
    }

    /* Git Revert */
    public static function revert(string $cambio){
        return shell_exec('git revert '. $cambio);
    }

    /* Git CheckOut */
    public static function checkout(string $cambio){
        return shell_exec('git checkout '. $cambio);
    }

}

?>