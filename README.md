# Custo Parlamentar: Descrição e Importância do Projeto

O projeto **Custo Parlamentar** reside na sua capacidade de integrar dados da API oficial da Câmara dos Deputados. Utilizando **Laravel Jobs**, o sistema faz requisições assíncronas para buscar informações cruciais, como o tipo de despesa (passagens aéreas, aluguel de escritórios, combustível, etc.), o valor gasto, o fornecedor de cada serviço ou produto e o período em que a despesa ocorreu.

Uma vez coletados, esses dados são cuidadosamente persistidos em um banco de dados **MySQL**. Essa centralização e estruturação das informações permitem não apenas consultas eficientes, mas também a base para análises mais complexas e visualizações que tornam as despesas mais compreensíveis. Todo o ambiente de desenvolvimento é isolado e replicável graças ao **Docker**, garantindo uma configuração descomplicada e um deploy consistente.

---

## Importância do Projeto

A relevância do Custo Parlamentar transcende o aspecto técnico, impactando diretamente a transparência e a fiscalização do dinheiro público:

* **Promovendo a Transparência:** O projeto atua como uma ponte entre os dados brutos da Câmara e o cidadão comum. Ao organizar e exibir as despesas de forma clara, ele democratiza o acesso à informação, facilitando que qualquer pessoa entenda como o dinheiro dos impostos está sendo utilizado pelos representantes eleitos.
* **Fortalecendo a Fiscalização Cidadã:** Com acesso facilitado a informações detalhadas, o Custo Parlamentar empodera a sociedade civil, jornalistas e pesquisadores. A ferramenta permite uma análise aprofundada dos padrões de gastos, possibilitando a identificação de anomalias ou o acompanhamento de tendências, o que é vital para uma fiscalização eficaz.
* **Base para Análise e Insights:** Os dados centralizados no MySQL abrem portas para análises mais sofisticadas. É possível gerar relatórios, gráficos comparativos entre deputados ou períodos, e identificar categorias de despesas que mais consomem recursos. Essa capacidade de gerar insights qualificados é fundamental para debates públicos informados sobre a gestão dos recursos parlamentares.
* **Demonstração de Habilidades Técnicas:** Para o contexto de um teste técnico, o Custo Parlamentar é uma excelente vitrine para proficiência em:
    * **Docker:** Orquestração de serviços e gerenciamento de ambientes.
    * **PHP/Laravel:** Desenvolvimento backend robusto, manipulação de filas (Jobs) e integração com banco de dados.
    * **MySQL:** Modelagem de dados e otimização de consultas.
    * **Consumo de APIs:** Interação com serviços externos.
    * **Arquitetura de Software:** Design para processamento de dados assíncrono e escalabilidade.

Em resumo, Custo Parlamentar não é apenas um exercício de programação, mas uma ferramenta prática que visa contribuir para a prestação de contas, a participação cívica e a saúde democrática, ao mesmo tempo em que demonstra um sólido domínio das tecnologias envolvidas.
