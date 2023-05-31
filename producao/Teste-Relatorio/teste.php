<?php
/*
Template Name: Relatório de Pedidos
*/

// Arrays para armazenar os dados do relatório
$report_data = array();
$payment_data = array();

// Obtém os pedidos
$args = array(
    'post_type' => 'mydelivery-orders',
    'posts_per_page' => -1,
);

$orders = new WP_Query($args);

// Loop pelos pedidos
if ($orders->have_posts()) {
    while ($orders->have_posts()) {
        $orders->the_post();
        $postid = get_the_ID();
        $order_items = get_field('order_items');
        $payment_method = get_post_meta($postid, 'order_payment_method', true);
        $post_title = get_the_title();

        // Loop pelos itens do pedido
        if ($order_items) {
            foreach ($order_items as $item) {
                $product_name = $item['order_product'];
                $quantidade = $product_name[0];
                
                $product_price = 0; // Inicializa o preço como zero
                
                
               
                
                
                $product_name = preg_replace('/\d+\s+x\s+/', '', $product_name);
                
                $produto_args = array(
                    'post_type' => 'mydelivery-produtos',
                    'posts_per_page' => 1,
                    's' => $product_name, // Utilize o valor de $product_name para buscar pelo título
                );
                
                $produto_query = new WP_Query($produto_args);
                
                if ($produto_query->have_posts()) {
                    $produto_query->the_post();
                    $product_price = get_field('product_price');
                    // Adicione o valor do preço ao total de vendas
                    $data['total_sales'] = $product_price;
                }
                
                // Restauro a consulta original
                wp_reset_postdata();
                
                // Adiciona os dados ao array de relatório
                $report_data[] = array(
                    'product_name' => $product_name,
                    'order_count' => $quantidade,
                    'total_sales' => $product_price,
                    'post_title' => $post_title,
                );

                // Adiciona os dados ao array de pagamentos
                $payment_data[] = array(
                    'payment_method' => $payment_method,
                    'order_count' => 1,
                    'total_sales' => $product_price,
                    'post_title' => $post_title,
                );
            }
        }
    }
    wp_reset_postdata();
}

// Criar um array para armazenar os produtos agrupados
$reduced_report_data = array();

// Percorrer o array $report_data
foreach ($report_data as $data) {
    $product_name = $data['product_name'];
    $order_count = $data['order_count'];

    // Verificar se o produto já existe no array $reduced_report_data
    if (array_key_exists($product_name, $reduced_report_data)) {
        // Produto já existe, somar o order_count existente com o novo order_count
        $reduced_report_data[$product_name]['order_count'] += $order_count;
    } else {
        // Produto não existe, adicionar ao array $reduced_report_data
        $reduced_report_data[$product_name] = $data;
    }
}

// Converter o array reduzido em formato JSON
$json_data = json_encode(array_values($reduced_report_data));

// Imprimir o JSON na tela
echo $json_data;
?>
