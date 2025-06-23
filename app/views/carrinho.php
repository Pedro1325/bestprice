<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Carrinho de Compras</title>
    <link rel="stylesheet" href="public/css/carrinho.css" />
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
</head>

<body class="carrinho-body">
    <?php include 'header.html'; ?>

    <header class="carrinho-header">
        <span>Carrinho de compras do <b>Best Price</b></span>
    </header>
    <main>

        <div class="content">
            <section>
                <table>
                    <thead>
                        <tr>
                            <th>Produto</th>
                            <th class="price_un">Preço</th>
                            <th>Quantidade</th>
                            <th>Total</th>
                            <th>-</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($itens)): ?>
                            <?php foreach ($itens as $item): ?>
                                <tr>
                                    <td>
                                        <div class="product">
                                            <img width="120px" height="auto"
                                                src="data:image/png;base64,<?= base64_encode($item['foto']) ?>"
                                                alt="<?= htmlspecialchars($item['nome']) ?>" />
                                            <div class="info">
                                                <div class="name"><?= htmlspecialchars($item['nome']) ?></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="price_un">R$ <?= number_format($item['valor_un'], 2, ',', '.') ?></td>
                                    <td>
                                        <div class="qty">
                                            <button class="carrinho-button bx bx-minus"
                                                onclick="decreaseQuantity(<?= $item['id_pedido'] ?>)"></button>
                                            <input class="quantity" type="number" value="<?= $item['quantidade'] ?>" min="1"
                                                max="<?= $item['quantidade_estoque'] ?>" data-pedido="<?= $item['id_pedido'] ?>"
                                                data-max="<?= $item['quantidade_estoque'] ?>"
                                                data-preco="<?= $item['valor_un'] ?>"
                                                onchange="updateQuantity(<?= $item['id_pedido'] ?>, this.value)" />
                                            <button class="carrinho-button bx bx-plus"
                                                onclick="increaseQuantity(<?= $item['id_pedido'] ?>, <?= $item['quantidade_estoque'] ?>)"></button>
                                        </div>
                                    </td>
                                    <td class="total-item">R$ <?= number_format($item['valor_total'], 2, ',', '.') ?></td>
                                    <td>
                                        <button class="remove" onclick="removeItem(<?= $item['id_pedido'] ?>)">
                                            <i class="bx bx-x"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" style="text-align: center;">Seu carrinho está vazio</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </section>
            <aside class="carrinho-aside">
                <fieldset class="box">
                    <header>Resumo da compra</header>
                    <div class="info">
                        <div>
                            <span>Sub-total</span>
                            <span class="subtotal">R$
                                <?= number_format(array_sum(array_column($itens, 'valor_total')), 2, ',', '.') ?></span>
                        </div>
                        <div>
                            <span>Frete</span>
                            <span id="valorFrete">R$ 0,00</span>
                        </div>
                        <div>
                            <button class="carrinho-button">
                                Adicionar cupom de desconto
                                <i class="bx bx-right-arrow-alt"></i>
                            </button>
                        </div>
                    </div>
                    <div class="total">

                        <div class="frete">
                            <h2>Calcular Frete</h2>
                            <label for="cep">Selecione o endereço de entrega:</label><br>
                            <select id="cep" name="cep" required>
                                <?php if (!empty($enderecos)): ?>
                                    <?php foreach ($enderecos as $endereco): ?>
                                        <option value="<?= $endereco['id_endereco'] ?>" data-cep="<?= $endereco['cep'] ?>">
                                            <?= htmlspecialchars($endereco['endereco_formatado']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <option value="">Nenhum endereço cadastrado</option>
                                <?php endif; ?>
                            </select>
                            <div class="calc">
                                <button onclick="calcularFrete()">Calcular Frete</button>
                            </div>
                        </div>

                        <div id="loading" style="display: none;">Calculando...</div>
                        <div class="res">
                            <div id="resultado"></div>
                        </div>

                    </div>
                    <footer>
                        <span>Total</span>
                        <span class="total-geral">R$
                            <?= number_format(array_sum(array_column($itens, 'valor_total')), 2, ',', '.') ?></span>
                    </footer>
                </fieldset>
                <div class="bot">
                    <button class="carrinho-button" onclick="finalizarCompra()">Finalizar Compra</button>
                </div>
            </aside>
        </div>
    </main>

    <script>
        // Função para formatar valores monetários
        // Função para formatar valores monetários
        function formatarValor(valor) {
            // Converte para número se for string
            if (typeof valor === 'string') {
                valor = parseFloat(valor.replace('R$', '').replace(/\./g, '').replace(',', '.'));
            }

            // Formata para o padrão brasileiro
            return valor.toLocaleString('pt-BR', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        }

        // Função para calcular e atualizar totais
        function atualizarTotais() {
            let subtotal = 0;

            // Calcula o total de cada item e o subtotal geral
            document.querySelectorAll('tbody tr').forEach(row => {
                const input = row.querySelector('.quantity');
                const precoUnitario = parseFloat(input.dataset.preco);
                const quantidade = parseInt(input.value);
                const totalItem = precoUnitario * quantidade;

                // Atualiza o total do item
                row.querySelector('.total-item').textContent = `R$ ${formatarValor(totalItem)}`;

                subtotal += totalItem;
            });

            // Atualiza o subtotal
            document.querySelector('.subtotal').textContent = `R$ ${formatarValor(subtotal)}`;

            // Atualiza o total geral considerando o frete
            const frete = parseFloat(localStorage.getItem('valorFrete')) || 0;
            const totalGeral = subtotal + frete;
            document.querySelector('.total-geral').textContent = `R$ ${formatarValor(totalGeral)}`;
        }

        // Adiciona event listeners para todos os inputs de quantidade
        document.addEventListener('DOMContentLoaded', function() {
            const quantityInputs = document.querySelectorAll('.quantity');
            quantityInputs.forEach(input => {
                input.addEventListener('input', function() {
                    const max = parseInt(this.dataset.max);
                    let value = parseInt(this.value);

                    // Se o valor for menor que 1, define como 1
                    if (value < 1 || isNaN(value)) {
                        this.value = 1;
                        value = 1;
                    }

                    // Se o valor for maior que o máximo, define como o máximo
                    if (value > max) {
                        this.value = max;
                        value = max;
                    }

                    // Atualiza os totais na interface
                    atualizarTotais();

                    // Atualiza a quantidade no servidor
                    updateQuantity(parseInt(this.dataset.pedido), value);
                });
            });
        });

        function updateQuantity(id_pedido, quantidade) {
            const input = document.querySelector(`input[data-pedido="${id_pedido}"]`);
            const max = parseInt(input.dataset.max);

            // Garante que a quantidade está dentro dos limites
            if (quantidade < 1) quantidade = 1;
            if (quantidade > max) quantidade = max;

            fetch('carrinho@atualizar', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `id_pedido=${id_pedido}&quantidade=${quantidade}`
                })
                .then(response => response.json())
                .then(data => {
                    if (!data.success) {
                        alert('Erro ao atualizar quantidade. Verifique se há estoque suficiente.');
                        // Reverte a quantidade para o valor anterior
                        input.value = data.quantidade_anterior;
                        atualizarTotais();
                    }
                });
        }

        function increaseQuantity(id_pedido, max_quantidade) {
            const input = document.querySelector(`input[data-pedido="${id_pedido}"]`);
            let quantidade = parseInt(input.value);
            if (quantidade < max_quantidade) {
                input.value = quantidade + 1;
                atualizarTotais();
                updateQuantity(id_pedido, quantidade + 1);
            }
        }

        function decreaseQuantity(id_pedido) {
            const input = document.querySelector(`input[data-pedido="${id_pedido}"]`);
            let quantidade = parseInt(input.value);
            if (quantidade > 1) {
                input.value = quantidade - 1;
                atualizarTotais();
                updateQuantity(id_pedido, quantidade - 1);
            }
        }

        function removeItem(id_pedido) {
            if (confirm('Deseja realmente remover este item do carrinho?')) {
                fetch(`carrinho@remover?id=${id_pedido}`, {
                        method: 'GET'
                    })
                    .then(response => {
                        if (response.ok) {
                            window.location.reload();
                        } else {
                            alert('Erro ao remover item do carrinho');
                        }
                    });
            }
        }

        function finalizarCompra() {

            if (confirm('Deseja prosseguir para o pagamento?')) {
                window.location.href = 'pagamento';
            }

        }

        let valorFrete = 0; // Variável global para armazenar o valor do frete
        let freteSelecionado = null; // Armazena o serviço de frete escolhido

        async function calcularFrete() {
            const enderecoSelect = document.getElementById('cep');
            const cepDestino = enderecoSelect.options[enderecoSelect.selectedIndex].getAttribute('data-cep');
            const resultadoDiv = document.getElementById('resultado');
            const loadingDiv = document.getElementById('loading');

            resultadoDiv.innerHTML = ''; // Limpa resultados anteriores
            resultadoDiv.classList.remove('error');

            if (!cepDestino || cepDestino.length !== 8) {
                resultadoDiv.innerHTML = '<p class="error">Por favor, selecione um endereço válido.</p>';
                resultadoDiv.classList.add('error');
                return; // Para a execução
            }

            loadingDiv.style.display = 'block';

            try {
                const response = await fetch('frete@calcular', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        cep: cepDestino
                    })
                });

                if (!response.ok) {
                    throw new Error(`Erro HTTP: ${response.status} ${response.statusText}`);
                }

                const data = await response.json();

                if (data.ShippingSevicesArray && data.ShippingSevicesArray.length > 0) {
                    let hasValidService = false;
                    let freteOptionsHtml = '<select class="frete-select" id="freteSelect">'; // Inicia o select de frete

                    // Exibe os serviços de frete disponíveis para o usuário escolher
                    data.ShippingSevicesArray.forEach(servico => {
                        if (!servico.Error && servico.ShippingPrice != null) {
                            const deliveryTime = servico.DeliveryTime || '?'; // Estimativa de dias de entrega

                            freteOptionsHtml += `<option value="${servico.ServiceCode}" data-preco="${servico.ShippingPrice}" data-entrega="${deliveryTime}">
                                <p>${servico.ServiceDescription || 'Serviço Desconhecido'} - R$ ${parseFloat(servico.ShippingPrice).toFixed(2).replace('.', ',')} 
                                (Entrega em ${deliveryTime} dia(s))</p>
                            </option>`;
                            hasValidService = true;
                        }
                    });

                    freteOptionsHtml += '</select>';

                    if (hasValidService) {
                        resultadoDiv.innerHTML = `
                            <p><strong>Escolha o tipo de frete:</strong></p>
                            ${freteOptionsHtml}
                            <p>Frete selecionado: <span id="freteSelecionado"></span></p>
                            <p>Estimativa de entrega: <span id="entregaEstimativa"></span></p>
                        `;

                        // Adiciona um evento de alteração para o select

                        document.getElementById('freteSelect').addEventListener('change', function() {
                            const selectedOption = this.options[this.selectedIndex];
                            freteSelecionado = selectedOption.value;
                            valorFrete = parseFloat(selectedOption.getAttribute('data-preco'));
                            const entregaEstimativa = selectedOption.getAttribute('data-entrega');
                            const freteServico = selectedOption.text; // Usando o nome do serviço como descrição

                            // Exibe o frete selecionado e a estimativa de entrega
                            document.getElementById('freteSelecionado').textContent = `R$ ${valorFrete.toFixed(2).replace('.', ',')}`;
                            document.getElementById('entregaEstimativa').textContent = `${entregaEstimativa} dia(s)`;

                            // Atualiza o total com o frete
                            atualizarTotalComFrete();

                            // Salva as informações no localStorage
                            localStorage.setItem('valorFrete', valorFrete.toFixed(2)); // Atualiza o valor do frete
                            localStorage.setItem('frete_estimativa', entregaEstimativa); // Atualiza a estimativa de entrega
                            localStorage.setItem('frete_servico', freteServico); // Atualiza o serviço de frete
                        });

                        ;
                    } else {
                        resultadoDiv.innerHTML = '<p class="error">Nenhum serviço de entrega válido encontrado para o CEP informado.</p>';
                        resultadoDiv.classList.add('error');
                    }
                } else if (data.erro) {
                    resultadoDiv.innerHTML = `<p class="error">${data.erro}</p>`;
                    resultadoDiv.classList.add('error');
                } else {
                    resultadoDiv.innerHTML = '<p class="error">Nenhum serviço disponível retornado pela API para o CEP informado.</p>';
                    resultadoDiv.classList.add('error');
                }
            } catch (err) {
                console.error("Erro ao calcular frete:", err);
                resultadoDiv.innerHTML = `<p class="error">Erro ao calcular frete: ${err.message}</p>`;
                resultadoDiv.classList.add('error');
            } finally {
                loadingDiv.style.display = 'none';
            }
        }

        function atualizarTotalComFrete() {
            const subtotalElement = document.querySelector('.subtotal');
            const totalGeralElement = document.querySelector('.total-geral');


            if (!subtotalElement || !totalGeralElement) {
                console.error("Elemento '.subtotal' ou '.total-geral' não encontrado.");
                if (totalGeralElement) totalGeralElement.textContent = "R$ Erro";
                return;
            }

            const subtotalTextoRaw = subtotalElement.textContent;

            let subtotalTextoLimpo = subtotalTextoRaw.replace('R$', '').trim();
            subtotalTextoLimpo = subtotalTextoLimpo.replace(/\./g, '');
            subtotalTextoLimpo = subtotalTextoLimpo.replace(',', '.');
            const subtotal = parseFloat(subtotalTextoLimpo);

            const frete = (typeof valorFrete === 'number' && !isNaN(valorFrete)) ? valorFrete : 0;

            if (isNaN(subtotal)) {
                console.error('Falha ao converter subtotal para número:', subtotalTextoRaw, '->', subtotalTextoLimpo);
                totalGeralElement.textContent = 'R$ NaN';
                return;
            }

            const totalGeral = subtotal + frete;

            totalGeralElement.textContent = `R$ ${totalGeral.toFixed(2).replace('.', ',')}`;

            // Atualiza o valor exibido do frete no resumo
            const valorFreteSpan = document.getElementById('valorFrete');
            if (valorFreteSpan) {
                valorFreteSpan.textContent = `R$ ${frete.toFixed(2).replace('.', ',')}`;
            }
        }


        document.addEventListener('DOMContentLoaded', function() {
            // Atualiza os totais quando a página carrega
            atualizarTotais();

            // Restante do código existente...
            const quantityInputs = document.querySelectorAll('.quantity');
            quantityInputs.forEach(input => {
                input.addEventListener('input', function() {
                    // Código existente...
                });
            });
        });
        
    </script>
</body>

</html>