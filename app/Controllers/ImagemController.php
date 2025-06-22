<?php

global $tabela;     $tabela = 'igreja';
global $sigla;      $sigla = 'ig';

class IgrejaController extends Actions {}

// <?php

// include "../bd/conexao.php";

// //$baseDiretorio = $baseUrl . 'painel/system/imagens/';
// $baseDiretorio = 'assets/imagens/';
// $folderPath = '../assets/imagens/';
// $acao = isset($_POST['acao']);

// if ($acao == 'deletar') {

//     $nomeArquivo = $_POST['name'];
//     $tipo = $_POST['tipo'];

//     $filename = $folderPath . $nomeArquivo;
//     unlink($filename);

//     $stmt = $pdo->prepare("DELETE FROM imagem WHERE img_nome = ? and img_tipo = ?");
//     $stmt->execute([$nomeArquivo,$tipo]);
// } else {

//     //$id = $_POST['id'];
//     $tipo = $_POST['tipo'];

//     $image_parts = explode(";base64,", $_POST['image']);
//     $image_type_aux = explode("image/", $image_parts[0]);
//     $image_type = $image_type_aux[1];
//     $image_base64 = base64_decode($image_parts[1]);

//     $Imagem = uniqid() . '.png';
//     $file = $folderPath . $Imagem;

//     file_put_contents($file, $image_base64);

//     $pathImage = $baseDiretorio . $Imagem;


//     if ($tipo == 1 || $tipo == 2 || $tipo == 4 || $tipo == 5 || $tipo == 6) { //1 - imagem perfil | 2 - imagem topo | 3 - imagem galeria | 4 - imagem oferta | 5 - imagem leads | 6 - logo sistema

//         $stmt = $pdo->prepare("SELECT * FROM imagem WHERE img_tipo = ?");
//         $stmt->execute([$tipo]);
//         $count = $stmt->rowCount();

//         if ($count != 0) {
//             try {
//                 $info = $stmt->fetchAll(PDO::FETCH_ASSOC);
//                 foreach ($info as $values) {
//                     $nome = $values['img_nome'];
//                 }
                
//                 if (file_exists($folderPath . $nome)) {
//                     unlink($folderPath . $nome);
//                 }

//                 $stmt = $pdo->prepare("UPDATE imagem SET img_nome = ?, img_url = ? WHERE img_tipo = ?");
//                 $stmt->execute([$Imagem, $pathImage, $tipo]);

//                 if($tipo == 6){
//                     $stmt=$pdo->prepare("UPDATE sistema SET sis_url_logo = ?");
//                     $stmt->execute([$pathImage]);
//                 }

//                 $data = ['acao' => 'salvo'];
//                 header('Content-type: application/json');
//                 echo json_encode($data);

//             } catch (PDOException $e) {
//                 $pdo->rollBack();

//                 // Enviar mensagem de erro para o Telegram
//                 sendTelegramMessage($e);
//             }
//         } else {

//             try {

//                 $pdo->beginTransaction();
//                 $stmt = $pdo->prepare("INSERT INTO imagem VALUES (null,?,?,?)");
//                 $stmt->execute([$Imagem, $pathImage, $tipo]);

//                 if($tipo == 6){
//                     $stmt=$pdo->prepare("UPDATE sistema SET sis_url_logo = ?");
//                     $stmt->execute([$pathImage]);
//                 }

//                 $pdo->commit();

//                 $data = ['acao' => 'salvo'];
//                 header('Content-type: application/json');
//                 echo json_encode($data);
//             } catch (Exception $e) {
//                 $pdo->rollBack();

//                 // Enviar mensagem de erro para o Telegram
//                 sendTelegramMessage($e);
//             }
//         }
//     } else {

//         try {

//             $pdo->beginTransaction();
//             $stmt = $pdo->prepare("INSERT INTO imagem VALUES (null,?,?,?,?)");
//             $stmt->execute([$id, $Imagem, $pathImage, $tipo]);
//             $pdo->commit();

//             $data = ['acao' => 'salvo'];
//             header('Content-type: application/json');
//             echo json_encode($data);
//         } catch (Exception $e) {
//             $pdo->rollBack();

//             // Enviar mensagem de erro para o Telegram
//             sendTelegramMessage($e);
//         }
//     }
// }
