# Classe Rdi_wp

## Instancie
A instância já carrega os códigos de autenticação

    $RDI = new Rdi_wp();

## Você pode adicionar os códigos pela instância da classe
O client_secret
    
    $RDI->setClientSecret('value');

O client_id
    
    $RDI->setClientId('value');

O code
    
    $RDI->setCode('value');

## Pegar as propriedades
O client_secret
    
    $RDI->getClientSecret();

O client_id
    
    $RDI->getClientId();

O code
    
    $RDI->getCode();

## Verificar se as propriedades existem
O client_secret
    
    $RDI->hasClientSecret();

O client_id
    
    $RDI->hasClientId();

O code
    
    $RDI->hasCode();

O access_token
    
    $RDI->hasAcessToken();

O refresh_token
    
    $RDI->hasRefreshToken();

## Recuperar dados
Dados de um contato pelo email: 
[Documentação no RD](https://developers.rdstation.com/pt-BR/reference/contacts#get_email).

    
    $RDI->getContactByEmail('email@email.com');

Enviar uma conversão: 
Veja na [documentação no RD](https://developers.rdstation.com/pt-BR/reference/events#events-post) a construção de 'params'.

    
    $RDI->sendConversionEvent('idendificador', params);

Editar um contato/lead: 
Veja na [documentação no RD](https://developers.rdstation.com/pt-BR/reference/contacts#patch) a construção de 'obj'.

    
    $RDI->editContact(idDoContato, obj);

Obter a lista de fields cadastrados: 
[Documentação no RD](https://developers.rdstation.com/pt-BR/reference/fields#field-get).

    
    $RDI->getFields();

Enjoy!
