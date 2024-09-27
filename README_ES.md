# FormAPI
La clase **FormAPI** es una utilidad en PHP diseñada para PocketMine-MP, que permite la creación y visualización de varios tipos de forms interactivos. Soporta Forms Simples, Forms Modals y Forms Custom, que proporcionan diferentes funcionalidades basadas en la entrada del usuario.

## Setup
Para configurar FormAPI en tu proyecto de PocketMine-MP, sigue estos pasos:
1. **Descargar la Versión:** Primero, descarga la última versión desde este repositorio. Recibirás un archivo comprimido que contiene todos los archivos necesarios.
2. **Extraer los Archivos:** Extrae el contenido de la versión descargada en el directorio `src` de tu plugin de PocketMine-MP. La estructura de carpetas debería verse así:
   ```scss
   YourPlugin/
   src/
     yourName/
       ...
     formspm/
       ...
    ```
3. **Incluir la Clase FormAPI:** En los archivos de tu plugin, incluye las clases necesarias de FormAPI utilizando el espacio de nombres adecuado:
   ```php
   use formspm\kamy\Form;
   use formspm\kamy\FormType;
   ```

## Simple Form
Un **SimpleForm** es un formulario básico que contiene un título y varios botones. Cada botón activa una acción dependiendo de la selección del usuario. Aquí tienes un ejemplo de cómo crear un Simple Form:
```php
// Crear una nueva instancia de Simple Form
$form = Form::create(FormType::SIMPLE_FORM);

// Establecer el título del formulario
$form->setTitle("Formulario Simple");

// Agregar botones al formulario. Cada botón se le asigna un índice que empieza desde 0.
// En este caso, "Botón 1" tiene el índice 0, y "Botón 2" tiene el índice 1.
$form->addButton("Botón 1");
$form->addButton("Botón 2");

// Establecer la acción que se ejecutará cuando el jugador envíe el formulario.
// El segundo argumento, $buttonId, representa el índice del botón que fue presionado.
$form->setSubmitAction(function (Player $player, int $buttonId) {
    // Estructura switch para manejar las pulsaciones de botones
    switch ($buttonId) {
        case 0:
            // Si se presionó el Botón 1 (índice 0)
            $player->sendMessage("Presionaste el Botón 1.");
            break;
        case 1:
            // Si se presionó el Botón 2 (índice 1)
            $player->sendMessage("Presionaste el Botón 2.");
            break;
        default:
            // Caso alternativo en caso de que se presione un botón desconocido (aunque no debería suceder con botones válidos)
            $player->sendMessage("Botón desconocido presionado.");
            break;
    }
});

// Enviar el formulario al jugador, mostrando el formulario en su cliente
$form->send($player);
```

### Funciones
1. **setTitle(string $title): void**
   - Establece el título del formulario.
   - **Ejemplo:**
     ```php
     $form->setTitle("Simple Form");
     ```
2. **addButton(string $text): void**
   - Añade un botón al formulario.
   - **Ejemplo:**
     ```php
     $form->addButton("Button 1");
     ```  
3. **setSubmitAction(Closure $action): void**
   - Define la acción que se ejecutará cuando se presione un botón. La acción se define mediante un Closure que toma como parámetros al jugador y el ID del botón.
   - **Ejemplo:**
     ```php
     $form->setSubmitAction(function (Player $player, int $buttonId) {
         // Handle button press
     });
     ```
4. **send(Player $player): void**
   - Envía el formulario al jugador.
   - **Ejemplo:**
     ```php
     $form->send($player);
     ```

## Modal Form
Un **ModalForm** proporciona dos opciones (usualmente "Sí" o "No") y es útil para cuadros de diálogo de confirmación. Aquí tienes un ejemplo de cómo crear un Modal Form:
```php
// Crea una nueva instancia de un Formulario Modal
$form = Form::create(FormType::MODAL_FORM);

// Establece el título del formulario modal
$form->setTitle("Modal Form");

// Establece el contenido o mensaje que se mostrará en el formulario modal
$form->setContent("¿Deseas continuar?");

// Establece las etiquetas para los dos botones. El Botón 1 es para "Sí" y el Botón 2 es para "No".
// Estos botones se presentan como opciones para que el jugador elija.
$form->setButton1("Sí");
$form->setButton2("No");

// Establece la acción a ejecutar cuando el jugador envíe el formulario modal.
// El $buttonId representa el índice del botón presionado por el jugador.
// Para un formulario modal, el Botón 1 ("Sí") corresponde al índice 0, y el Botón 2 ("No") corresponde al índice 1.
$form->setSubmitAction(function (Player $player, int $buttonId) {
    // Verifica si se presionó el botón "Sí" (índice 0)
    if ($buttonId === 0) {
        // Envía un mensaje al jugador indicando que presionó "Sí"
        $player->sendMessage("Presionaste 'Sí'.");
    } else {
        // Si se presionó el botón "No" (índice 1), envía este mensaje
        $player->sendMessage("Presionaste 'No'.");
    }
});

// Envía el formulario modal al jugador
$form->send($player);
```

### Functions
1. **setTitle(string $title): void**
   - Establece el título del formulario.
   - **Ejemplo:**
     ```php
     $form->setTitle("Modal Form");
     ```
2. **setContent(string $content): void**
   - Establece el contenido (mensaje principal) del form modal.
   - **Ejemplo:**
     ```php
     $form->setContent("Do you want to proceed?");
     ```
3. **setButton1(string $text): void**
   - Establece el texto para el primer botón (generalmente el botón "Sí").
   - **Ejemplo:**
     ```php
     $form->setButton1("Yes");
     ```
4. **setButton1(string $text): void**
   - Establece el texto para el segundo botón (generalmente el botón "No").
   - **Ejemplo:**
     ```php
     $form->setButton2("No");
     ```
5. **setSubmitAction(Closure $action): void**
   - Define la acción a ejecutar cuando se presiona uno de los botones.
   - **Ejemplo:**
     ```php
     $form->setSubmitAction(function (Player $player, int $buttonId) {
         // Handle button press
     });
     ```

## Custom Form
Un **CustomForm** permite entradas más complejas, como campos de texto (inputs), deslizadores (sliders) y menús desplegables (dropdown).
Aquí tienes un ejemplo de cómo crear un Custom Form:
```php
// Crea una nueva instancia de Formulario Personalizado
$form = Form::create(FormType::CUSTOM_FORM);

// Establece el título del formulario personalizado
$form->setTitle("Formulario Personalizado");

// Agrega un campo de entrada donde el jugador puede ingresar su nombre
// El primer parámetro es la etiqueta mostrada al jugador, y el segundo es un texto de marcador de posición
$form->addInput("¿Cuál es tu nombre?", "Ej. Juan");

// Agrega un deslizador donde el jugador puede seleccionar su edad
// El deslizador permite seleccionar un valor entre 0 y 100, siendo 18 el valor predeterminado
$form->addSlider("Selecciona tu edad", 0, 100, 18);

// Agrega una lista desplegable para que el jugador elija un color
// La lista desplegable contiene tres opciones: "Rojo", "Verde" y "Azul"
$form->addDropdown("Elige un color", ["Rojo", "Verde", "Azul"]);

// Establece la acción a realizar cuando se envía el formulario
// El array $data contiene las respuestas del jugador: $data[0] es el nombre, $data[1] es la edad seleccionada, y $data[2] es el color elegido
$form->setSubmitAction(function (Player $player, $data) {
    // Obtiene el nombre ingresado por el jugador; si no se ingresa ninguno, se establece por defecto en "Ninguno"
    $name = $data[0] ?? "Ninguno";
    
    // Obtiene la edad seleccionada por el jugador del deslizador; si no se proporciona un valor, se establece por defecto en 0
    $age = $data[1] ?? 0;
    
    // Obtiene el color seleccionado por el jugador de la lista desplegable; si no se selecciona ninguno, se establece por defecto en "Ninguno"
    $color = $data[2] ?? "Ninguno";
    
    // Envía un mensaje al jugador resumiendo sus entradas: nombre, edad y color elegido
    $player->sendMessage("Nombre: $name, Edad: $age, Color: $color");
});

// Envía el formulario personalizado al jugador para interacción
$form->send($player);
```

### Functions
1. **setTitle(string $title): void**
   - Establece el título del formulario.
   - **Ejemplo:**
     ```php
     $form->setTitle("Custom Form");
     ```
2. **addInput(string $placeholder, ?string $default = null): void**
   - Agrega un campo de entrada donde el jugador puede escribir texto.
   - **Ejemplo:**
     ```php
     $form->addInput("What is your name?", "E.g. John");
     ```
3. **addSlider(string $label, float $min, float $max, float $default): void**
   - Agrega un campo de deslizador donde el jugador puede seleccionar un valor dentro de un rango.
   - **Ejemplo:**
     ```php
     $form->addSlider("Select your age", 0, 100, 18);
     ```
4. **addDropdown(string $label, array $options): void**
   - Agrega un menú desplegable donde el jugador puede seleccionar de una lista de opciones.
   - **Ejemplo:**
     ```php
     $form->addDropdown("Choose a color", ["Red", "Green", "Blue"]);
     ```
5. **setSubmitAction(Closure $action): void**
   - Define la acción a ejecutar cuando se envía el formulario.
   - **Ejemplo:**
     ```php
     $form->setSubmitAction(function (Player $player, $data) {
         // Handle formspm submission
     });
     ```

# Licencia
Este proyecto está licenciado bajo la Licencia MIT. Consulta el archivo [LICENSE](LICENSE) para más información.
