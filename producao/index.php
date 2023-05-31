<?php
if (have_rows('selecione_adicional')) :
    while (have_rows('selecione_adicional')) : the_row();
        $titulo = get_sub_field('titulo');
        $adicionais = get_sub_field('escolha_o_seu_adicional');

        echo '<div class="cardapius-body">';
        echo '<div class="cardapius-cabecalho-adicional">';
        echo '<h3>' . $titulo . '</h3>';
        echo '<p><span>1</span>/<span>2</span></p>';
        echo '</div>';

        if ($adicionais) :
            foreach ($adicionais as $adicionais_post) :
                $image_id = get_field('imagem_do_adicional', $adicionais_post->ID);
                $image_url = wp_get_attachment_image_src($image_id, 'full')[0];
                $descricao = get_field('descricao_do_adicional', $adicionais_post->ID);
                $valor = get_field('valor_do_adicional', $adicionais_post->ID);
                $limiteAdicional = get_field('limite_de_adicional', $adicionais_post->ID);

                // Converter para float com duas casas decimais
                $valor = number_format((float)$valor, 2, '.', '');

                // Trocar o ponto por vírgula
                $valor = str_replace('.', ',', $valor);

                // Adicionar zeros à direita, caso necessário
                if (strpos($valor, ',') === false) {
                    $valor .= ',00';
                } else {
                    $partes = explode(',', $valor);
                    if (strlen($partes[1]) === 1) {
                        $valor .= '0';
                    }
                }
                if ($valor == '0' || $valor == '0,00' || $valor == '0.00'){
                    $valor = 'GRATÍS';
                }
                ?>
                <div class="cardapius-div-adicional">
                    <?php
                    if ($image_id || $image_url != "") :
                        echo '<img class="cardapius-imagem-adicional" src="' . $image_url . '" alt="">';
                    endif;
                    ?>
					<div>
                    	<h3 class="cardapius-name-adicional"><?php echo $adicionais_post->post_title; ?><p class="cardapius-adicional-price"><?php
                        if($valor == 'GRATÍS'){
                            echo $valor;
                        } else {
                            echo 'R$ ' . $valor;
                        }
                         ?></p></h3>
					</div>	
                    <div class="cardapius-input-group">
                        <button class="cardapius-btn cardapius-btn-minus" type="button">-</button>
                        <input class="cardapius-input-number" type="number" value="0" min="0" max="<?php
                        if($limiteAdicional > 0){
                            echo $limiteAdicional;
                        } else {
                            echo '3';
                        }?>" name="cardapius-quantidade-adicional" id="cardapius-quantidade-adicional">
                        <button class="cardapius-btn cardapius-btn-plus" type="button">+</button>
                        
                    </div>
                </div>
                <div class="cardapius-adicional-descricao">
                        <?php echo $descricao; ?>
                </div>
            <?php endforeach;
        endif;
        echo '</div>';
    endwhile;
endif;
?>

<?php
if (have_rows('selecione_opcionais')) {
    ?>
    <div class="cardapius-opcionais-title-opcionais">
        <h3 class="cardapius-opcionais-title-opcionais-h3">OPCIONAIS</h3>
    </div>
    <?php
    while (have_rows('selecione_opcionais')) {
        the_row();
        $tituloOpcional = get_sub_field('titulo');
        $opcionais = get_sub_field('escolha_seus_opcionais');
        $limiteOpcional = get_sub_field('limite_de_opcionais');
        $opcionalObrigatorio = get_sub_field('e_obrigatorio');
        $titleSlug = strtolower(str_replace(' ', '-', $tituloOpcional));
        ?>
        <div class="cardapius-opcional-title" id="<?php echo $titleSlug;?>">
            <h3><?php echo $tituloOpcional;?></h3>
            <?php 
            if($opcionalObrigatorio > 0){
               echo '<p class="cardapius-opcional-obrigatorio">OBRIGATORIO</p>';
            };?>
            <p class="cardapius-opcional-limit"><span class="cardapius-min">0</span>/<span class="cardapius-opcional-max"><?php echo $limiteOpcional;?></span></p>
        </div>
        <?php
        if ($opcionais) {
            foreach ($opcionais as $opcionais_post) {
                $image_id = get_field('imagem_do_adicional', $opcionais_post->ID);
                $image_url = wp_get_attachment_image_src($image_id, 'full')[0];
                $descricao = get_field('descricao_do_adicional', $opcionais_post->ID);
                $titlePostOpcional = $opcionais_post->post_title;
                $postSlugOpcional = strtolower(str_replace(' ', '-', $titlePostOpcional));
                ?>
                <div class="cardapius-opcional-list">
                    <?php
                    if ($image_id || $image_url != "") {
                        echo '<img class="cardapius-imagem-adicional" src="' . $image_url . '" alt="">';
                    };
                    ?>
                    <label class="cardapius-label-opcional" for="<?php echo  $postSlugOpcional;?>"><?php echo $titlePostOpcional;?></label>
                    <input class="cardapius-radio-opcional" type="checkbox" name="<?php echo $titleSlug;?>" id="<?php echo  $postSlugOpcional;?>">
                </div>

                <?php
            }
        }
    }
}
?>







<?php
if (have_rows('selecione_opcionais')) :
    while (have_rows('selecione_opcionais')) : the_row();
        $titulo = get_sub_field('titulo');
        $adicionais = get_sub_field('escolha_seus_opcionais');
        //indo para o HTML

        echo '<div class="cardapius-body">';
        echo '<div class="cardapius-cabecalho-adicional">';
        echo '<h3>' . $titulo . '</h3>';
        echo '<p><span>1</span>/<span>2</span></p>';
        echo '</div>';

        if ($adicionais) :
            foreach ($adicionais as $adicionais_post) :
                $image_id = get_field('imagem_do_adicional', $adicionais_post->ID);
                $image_url = wp_get_attachment_image_src($image_id, 'full')[0];
                $descricao = get_field('descricao_do_adicional', $adicionais_post->ID);
                $valor = get_field('valor_do_adicional', $adicionais_post->ID);

                // Converter para float com duas casas decimais
                $valor = number_format((float)$valor, 2, '.', '');

                // Trocar o ponto por vírgula
                $valor = str_replace('.', ',', $valor);

                // Adicionar zeros à direita, caso necessário
                if (strpos($valor, ',') === false) {
                    $valor .= ',00';
                } else {
                    $partes = explode(',', $valor);
                    if (strlen($partes[1]) === 1) {
                        $valor .= '0';
                    }
                }
                if ($valor == '0' || $valor == '0,00' || $valor == '0.00'){
                    $valor = 'GRATÍS';
                }
                ?>
                <div class="cardapius-div-adicional">
                    <?php
                    if ($image_id || $image_url != "") :
                        echo '<img class="cardapius-imagem-adicional" src="' . $image_url . '" alt="">';
                    endif;
                    ?>
					<div>
                    	<h3 class="cardapius-name-adicional"><?php echo $adicionais_post->post_title; ?><p class="cardapius-adicional-price"><?php
                        if($valor == 'GRATÍS'){
                            echo $valor;
                        } else {
                            echo 'R$ ' . $valor;
                        }
                         ?></p></h3>
					</div>	
                    <div class="cardapius-input-group">
                        <button class="cardapius-btn cardapius-btn-minus" type="button">-</button>
                        <input class="cardapius-input-number" type="number" value="0" min="0" max="10" name="cardapius-quantidade-adicional" id="cardapius-quantidade-adicional">
                        <button class="cardapius-btn cardapius-btn-plus" type="button">+</button>
                        
                    </div>
                </div>
                <div class="cardapius-adicional-descricao">
                        <?php echo $descricao; ?>
                </div>
            <?php endforeach;
        endif;

        echo '</div>';
    endwhile;
endif;
?>