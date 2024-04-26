<?php

require_once './Models/VendedorModel.php';
require_once './Models/ClienteModel.php';
require_once './Models/OrdenModel.php';
require_once './Models/FacturaModel.php';
require_once './includes/ActiveRecord.php';

class APIController
{

    // --------------------------- API VENDEDOR -----------------------------
    public static function obtenerVendedorPorId($id)
    {
        $vendedor = VendedorModel::find($id);

        try {
            // Verificamos si se encontró el vendedor mediante la consulta
            if ($vendedor) {
                echo json_encode($vendedor);
            } else {
                // Si no se encontró el vendedor, retornar un JSON con el mensaje 'No se encontró por ID'
                echo json_encode(['mensaje' => 'No se encontro por ID']);
            }
        } catch (\Throwable $th) {
            echo json_encode(['error' => $th->getMessage()]);
        }
    }

    public static function crearVendedor()
    {
        // Obtenemos los datos enviados en el cuerpo de la solicitud POST
        $datos = json_decode(file_get_contents("php://input"), true);

        try {
            // Validamos los datos del vendedor utilizando el método validarDatos del modelo VendedorModel
            $alertas = VendedorModel::validarDatos($datos);

            if (!empty($alertas['error'])) {
                // Si hay errores, retornar un JSON con los mensajes de error
                echo json_encode(['error' => $alertas['error']]);
                return;
            }

            // Creamos un nuevo objeto VendedorModel con los datos proporcionados
            $nuevoVendedor = new VendedorModel($datos);

            // Intentamos guardar el nuevo vendedor en la base de datos
            $resultado = $nuevoVendedor->guardar();

            // Verificamos si la operación de guardado fue exitosa
            if ($resultado['resultado']) {
                // Si el vendedor se creó exitosamente, retornar un JSON con el ID del nuevo vendedor
                echo json_encode(['Creado' => $resultado['id']]);
            } else {
                // Si ocurrió un error al crear el vendedor, retornar un JSON con un mensaje de error específico
                echo json_encode(['error' => $resultado['mensaje']]);
            }
        } catch (\Throwable $th) {
            echo json_encode(['error' => $th->getMessage()]);
        }
    }

    public static function actualizarVendedorPorId($id)
    {
        // Obtenemos los datos enviados en el cuerpo de la solicitud PUT
        $datos = json_decode(file_get_contents("php://input"), true);

        try {
            // Verificamos si se recibieron datos para actualizar
            if (empty($datos)) {
                // Si no se recibieron datos para actualizar, retornar un JSON con un mensaje de error
                echo json_encode(['error' => 'No se recibieron datos para actualizar']);
                return;
            }

            // Encontramos el vendedor por ID, no hace falta instanciarlo, así que lo llamamos como estático
            $vendedor = VendedorModel::find($id);

            // Verificamos si se encontró el vendedor por su ID
            if ($vendedor) {
                // Validamos los datos del vendedor PARAMETRIZADO utilizando el método checkDatos del modelo VendedorModel
                $alertas = VendedorModel::checkDatos($datos);

                if (!empty($alertas['error'])) {
                    // Si hay errores, retornar un JSON con los mensajes de error
                    echo json_encode(['error' => $alertas['error']]);
                    return;
                }

                // Actualizamos los campos del vendedor con los datos proporcionados
                foreach ($datos as $campo => $valor) {
                    // Verificamos si el campo existe en el modelo y actualizar su valor
                    if (property_exists($vendedor, $campo)) {
                        $vendedor->{$campo} = $valor;
                    }
                }

                // Intentamos guardar los cambios en el vendedor
                $resultado = $vendedor->guardar();

                // Verificamos si la operación de actualización fue exitosa
                if ($resultado['resultado']) {
                    // Si la actualización fue exitosa, retornar un JSON con un mensaje de éxito
                    echo json_encode(['mensaje' => 'Vendedor actualizado correctamente']);
                } else {
                    // Si ocurrió un error al actualizar el vendedor, retornar un JSON con un mensaje de error específico
                    echo json_encode(['error' => $resultado['mensaje']]);
                }
            } else {
                // Si no se encontró el vendedor por su ID, retornar un JSON con un mensaje de error
                echo json_encode(['error' => 'No se encontro el vendedor con el ID proporcionado']);
            }
        } catch (\Throwable $th) {
            echo json_encode(['error' => $th->getMessage()]);
        }
    }


    public static function eliminarVendedorPorId($id)
    {
        // Creamos un objeto VendedorModel para el vendedor a eliminar
        $vendedor = VendedorModel::find($id);

        try {
            //Verificamos si se encontró el vendedor por su ID
            if ($vendedor) {
                // Intentamos eliminar el vendedor
                $resultado = $vendedor->eliminar();

                // Verificamos si la operación de eliminación fue exitosa
                if ($resultado) {
                    // Si la eliminación fue exitosa, retornar un JSON con un mensaje de éxito
                    echo json_encode(['mensaje' => 'Vendedor eliminado correctamente']);
                } else {
                    // Si ocurrió un error al eliminar el vendedor, retornar un JSON con un mensaje de error específico
                    echo json_encode(['error' => 'Error al eliminar el vendedor']);
                }
            } else {
                // Si no se encontró el vendedor por su ID, retornar un JSON con un mensaje de error
                echo json_encode(['error' => 'No se encontro el vendedor con el ID proporcionado']);
            }
        } catch (\Throwable $th) {
            echo json_encode(['error' => $th->getMessage()]);
        }
    }

    // -----------------------------------------------------------

    // --------------------------- API CLIENTE -----------------------------
    public static function obtenerClientePorId($id)
    {
        $cliente = ClienteModel::find($id);

        try {
            // Verificamos si se encontró el cliente mediante la consulta
            if ($cliente) {
                echo json_encode($cliente);
            } else {
                // Si no se encontró el cliente, retornar un JSON con el mensaje 'No se encontró por ID'
                echo json_encode(['mensaje' => 'No se encontro por ID']);
            }
        } catch (\Throwable $th) {
            echo json_encode(['error' => $th->getMessage()]);
        }
    }

    public static function crearCliente()
    {
        // Obtenemos los datos enviados en el cuerpo de la solicitud POST
        $datos = json_decode(file_get_contents("php://input"), true);

        try {
            // Validamos los datos del cliente utilizando el método validarDatos del modelo ClienteModel
            $alertas = ClienteModel::validarDatos($datos);

            if (!empty($alertas['error'])) {
                // Si hay errores, retornar un JSON con los mensajes de error
                echo json_encode(['error' => $alertas['error']]);
                return;
            }

            // Creamos un nuevo objeto VendedorModel con los datos proporcionados
            $nuevoCliente = new ClienteModel($datos);

            // Intentamos guardar el nuevo vendedor en la base de datos
            $resultado = $nuevoCliente->guardar();

            // Verificamos si la operación de guardado fue exitosa
            if ($resultado['resultado']) {
                // Si el vendedor se creó exitosamente, retornar un JSON con el ID del nuevo vendedor
                echo json_encode(['Creado' => $resultado['id']]);
            } else {
                // Si ocurrió un error al crear el vendedor, retornar un JSON con un mensaje de error específico
                echo json_encode(['error' => $resultado['mensaje']]);
            }
        } catch (\Throwable $th) {
            echo json_encode(['error' => $th->getMessage()]);
        }
    }

    public static function actualizarClientePorId($id)
    {
        // Obtenemos los datos enviados en el cuerpo de la solicitud PUT
        $datos = json_decode(file_get_contents("php://input"), true);

        try {
            // Verificamos si se recibieron datos para actualizar
            if (empty($datos)) {
                // Si no se recibieron datos para actualizar, retornar un JSON con un mensaje de error
                echo json_encode(['error' => 'No se recibieron datos para actualizar']);
                return;
            }

            // Encontramos el cliente por ID, no hace falta instanciarlo, así que lo llamamos como estático
            $cliente = ClienteModel::find($id);

            // Verificamos si se encontró el cliente por su ID
            if ($cliente) {
                // Validamos los datos del cliente PARAMETRIZADO utilizando el método checkDatos del modelo ClienteModel
                $alertas = ClienteModel::checkDatos($datos);

                if (!empty($alertas['error'])) {
                    // Si hay errores, retornar un JSON con los mensajes de error
                    echo json_encode(['error' => $alertas['error']]);
                    return;
                }

                // Actualizamos los campos del cliente con los datos proporcionados
                foreach ($datos as $campo => $valor) {
                    // Verificamos si el campo existe en el modelo y actualizar su valor
                    if (property_exists($cliente, $campo)) {
                        $cliente->{$campo} = $valor;
                    }
                }

                // Intentamos guardar los cambios en el cliente
                $resultado = $cliente->guardar();

                // Verificamos si la operación de actualización fue exitosa
                if ($resultado['resultado']) {
                    // Si la actualización fue exitosa, retornar un JSON con un mensaje de éxito
                    echo json_encode(['mensaje' => 'Cliente actualizado correctamente']);
                } else {
                    // Si ocurrió un error al actualizar el Cliente, retornar un JSON con un mensaje de error específico
                    echo json_encode(['error' => $resultado['mensaje']]);
                }
            } else {
                // Si no se encontró el cliente por su ID, retornar un JSON con un mensaje de error
                echo json_encode(['error' => 'No se encontro el cliente con el ID proporcionado']);
            }
        } catch (\Throwable $th) {
            echo json_encode(['error' => $th->getMessage()]);
        }
    }


    public static function eliminarClientePorId($id)
    {
        // Creamos un objeto ClienteModel para el cliente a eliminar
        $cliente = ClienteModel::find($id);

        try {
            // Verificamos si se encontró el cliente por su ID
            if ($cliente) {
                // Intentamos eliminar el cliente
                $resultado = $cliente->eliminar();

                // Verificamos si la operación de eliminación fue exitosa
                if ($resultado) {
                    // Si la eliminación fue exitosa, retornar un JSON con un mensaje de éxito
                    echo json_encode(['mensaje' => 'Cliente eliminado correctamente']);
                } else {
                    // Si ocurrió un error al eliminar el cliente, retornar un JSON con un mensaje de error específico
                    echo json_encode(['error' => 'Error al eliminar el cliente']);
                }
            } else {
                // Si no se encontró el cliente por su ID, retornar un JSON con un mensaje de error
                echo json_encode(['error' => 'No se encontro el vendedor con el ID proporcionado']);
            }
        } catch (\Throwable $th) {
            echo json_encode(['error' => $th->getMessage()]);
        }
    }

    // -----------------------------------------------------------



    // --------------------------- API ORDENGASOLINA -----------------------------
    public static function obtenerOrdenPorId($id)
    {
        $orden = OrdenModel::find($id);

        try {
            // Verificamos si se encontró la orden mediante la consulta
            if ($orden) {
                echo json_encode($orden);
            } else {
                // Si no se encontró la orden, retornar un JSON con el mensaje 'No se encontró por ID'
                echo json_encode(['mensaje' => 'No se encontro por ID']);
            }
        } catch (\Throwable $th) {
            echo json_encode(['error' => $th->getMessage()]);
        }
    }

    public static function crearOrden()
    {
        // Obtenemos los datos enviados en el cuerpo de la solicitud POST
        $datos = json_decode(file_get_contents("php://input"), true);

        try {
            // Validamos los datos de la orden utilizando el método validarDatos del modelo OrdenModel
            $alertas = OrdenModel::validarDatos($datos);

            if (!empty($alertas['error'])) {
                // Si hay errores, retornar un JSON con los mensajes de error
                echo json_encode(['error' => $alertas['error']]);
                return;
            }

            // Creamos un nuevo objeto OrdenModel con los datos proporcionados
            $nuevaOrden = new OrdenModel($datos);

            // Intentamos guardar el nuevo vendedor en la base de datos
            $resultado = $nuevaOrden->guardar();

            // Verificamos si la operación de guardado fue exitosa
            if ($resultado['resultado']) {
                // Si la orden se creó exitosamente, retornar un JSON con el ID de la nueva orden
                echo json_encode(['Creado' => $resultado['id']]);
            } else {
                // Si ocurrió un error al crear la orden, retornar un JSON con un mensaje de error específico
                echo json_encode(['error' => $resultado['mensaje']]);
            }
        } catch (\Throwable $th) {
            echo json_encode(['error' => $th->getMessage()]);
        }
    }

    public static function actualizarOrdenPorId($id)
    {
        // Obtenemos los datos enviados en el cuerpo de la solicitud PUT
        $datos = json_decode(file_get_contents("php://input"), true);

        try {
            // Verificamos si se recibieron datos para actualizar
            if (empty($datos)) {
                // Si no se recibieron datos para actualizar, retornar un JSON con un mensaje de error
                echo json_encode(['error' => 'No se recibieron datos para actualizar']);
                return;
            }

            // Encontramos la orden por ID, no hace falta instanciarlo, así que lo llamamos como estático
            $orden = OrdenModel::find($id);

            // Verificamos si se encontró la orden por su ID
            if ($orden) {
                // Validamos los datos de la orden PARAMETRIZADO utilizando el método checkDatos del modelo OrdenModel
                $alertas = OrdenModel::checkDatos($datos);

                if (!empty($alertas['error'])) {
                    // Si hay errores, retornar un JSON con los mensajes de error
                    echo json_encode(['error' => $alertas['error']]);
                    return;
                }

                // Actualizamos los campos de la orden con los datos proporcionados
                foreach ($datos as $campo => $valor) {
                    // Verificamos si el campo existe en el modelo y actualizar su valor
                    if (property_exists($orden, $campo)) {
                        $orden->{$campo} = $valor;
                    }
                }

                // Intentamos guardar los cambios en la orden
                $resultado = $orden->guardar();

                // Verificamos si la operación de actualización fue exitosa
                if ($resultado['resultado']) {
                    // Si la actualización fue exitosa, retornar un JSON con un mensaje de éxito
                    echo json_encode(['mensaje' => 'Orden actualizada correctamente']);
                } else {
                    // Si ocurrió un error al actualizar la orden, retornar un JSON con un mensaje de error específico
                    echo json_encode(['error' => $resultado['mensaje']]);
                }
            } else {
                // Si no se encontró la orden por su ID, retornar un JSON con un mensaje de error
                echo json_encode(['error' => 'No se encontro la orden con el ID proporcionado']);
            }
        } catch (\Throwable $th) {
            echo json_encode(['error' => $th->getMessage()]);
        }
    }


    public static function eliminarOrdenPorId($id)
    {
        // Creamos un objeto OrdenModel para la orden a eliminar
        $orden = OrdenModel::find($id);

        try {
            // Verificamos si se encontró la orden por su ID
            if ($orden) {
                // Intentamos eliminar la orden
                $resultado = $orden->eliminar();

                // Verificamos si la operación de eliminación fue exitosa
                if ($resultado) {
                    // Si la eliminación fue exitosa, retornar un JSON con un mensaje de éxito
                    echo json_encode(['mensaje' => 'Orden eliminada correctamente']);
                } else {
                    // Si ocurrió un error al eliminar la orden, retornar un JSON con un mensaje de error específico
                    echo json_encode(['error' => 'Error al eliminar la orden']);
                }
            } else {
                // Si no se encontró la orden por su ID, retornar un JSON con un mensaje de error
                echo json_encode(['error' => 'No se encontro la orden con el ID proporcionado']);
            }
        } catch (\Throwable $th) {
            echo json_encode(['error' => $th->getMessage()]);
        }
    }

    // -----------------------------------------------------------

    // --------------------------- API FACTURA -----------------------------
    public static function obtenerFacturaPorId($id)
    {
        $factura = FacturaModel::find($id);

        try {
            // Verificamos si se encontró la orden mediante la consulta
            if ($factura) {
                echo json_encode($factura);
            } else {
                // Si no se encontró la orden, retornar un JSON con el mensaje 'No se encontró por ID'
                echo json_encode(['mensaje' => 'No se encontro por ID']);
            }
        } catch (\Throwable $th) {
            echo json_encode(['error' => $th->getMessage()]);
        }
    }

    public static function crearFactura()
    {
        // Obtenemos los datos enviados en el cuerpo de la solicitud POST
        $datos = json_decode(file_get_contents("php://input"), true);

        try {
            // Validamos los datos de la orden utilizando el método validarDatos del modelo FacturalModel
            $alertas = FacturaModel::validarDatos($datos);

            if (!empty($alertas['error'])) {
                // Si hay errores, retornar un JSON con los mensajes de error
                echo json_encode(['error' => $alertas['error']]);
                return;
            }

            // Creamos un modelo de cada uno de los datos que vienen desde el POST para luego intentar buscar por ID si existen o no, esto con el objetivo de agregar datos que ÚNICAMENTE existan en las tablas.
            $cliente = ClienteModel::find($datos['id_cliente']);
            $vendedor = VendedorModel::find($datos['id_vendedor']);
            $orden = OrdenModel::find($datos['id_ordengasolina']);

            // Si de manera exitosa obtenemos que existe un cliente/vendedor/orden con esas IDs, procedemos con el resto del código.
            if ($cliente && $vendedor && $orden) {
                // Creamos un nuevo objeto FacturaModel con los datos proporcionados
                $nuevaFactura = new FacturaModel($datos);

                // Intentamos guardar la nueva factura en la base de datos
                $resultado = $nuevaFactura->guardar();

                // Verificamos si la operación de guardado fue exitosa
                if ($resultado['resultado']) {
                    // Si la factura se creó exitosamente, retornar un JSON con el ID de la nueva factura
                    echo json_encode(['Creado' => $resultado['id']]);
                } else {
                    // Si ocurrió un error al crear la factura, retornar un JSON con un mensaje de error específico
                    echo json_encode(['error' => $resultado['mensaje']]);
                }
            } else {
                echo json_encode(['error' => 'Alguno de los parametros ingresados no concuerda con las IDs en la tabla']);
            }
        } catch (\Throwable $th) {
            echo json_encode(['error' => $th->getMessage()]);
        }
    }

    public static function actualizarFacturaPorId($id)
    {
        // Obtenemos los datos enviados en el cuerpo de la solicitud PUT
        $datos = json_decode(file_get_contents("php://input"), true);

        try {
            // Verificamos si se recibieron datos para actualizar
            if (empty($datos)) {
                // Si no se recibieron datos para actualizar, retornar un JSON con un mensaje de error
                echo json_encode(['error' => 'No se recibieron datos para actualizar']);
                return;
            }

            // Encontramos la factura por ID, no hace falta instanciarlo, así que lo llamamos como estático
            $factura = FacturaModel::find($id);

            // Verificamos si se encontró la factura por su ID y también los demás
            if ($factura) {
                // Validamos los datos de la orden PARAMETRIZADO utilizando el método checkDatos del modelo FacturaModel
                $alertas = FacturaModel::checkDatos($datos);

                if (!empty($alertas['error'])) {
                    // Si hay errores, retornar un JSON con los mensajes de error
                    echo json_encode(['error' => $alertas['error']]);
                    return;
                }

                // Actualizamos los campos de la factura con los datos proporcionados
                foreach ($datos as $campo => $valor) {
                    // Verificamos si el campo existe en el modelo y actualizar su valor
                    if (property_exists($factura, $campo)) {
                        $factura->{$campo} = $valor;
                    }
                }

                // Intentamos guardar los cambios en la factura
                $resultado = $factura->guardar();

                // Verificamos si la operación de actualización fue exitosa
                if ($resultado['resultado']) {
                    // Si la actualización fue exitosa, retornar un JSON con un mensaje de éxito
                    echo json_encode(['mensaje' => 'Factura actualizada correctamente']);
                } else {
                    // Si ocurrió un error al actualizar la factura, retornar un JSON con un mensaje de error específico
                    echo json_encode(['error' => $resultado['mensaje']]);
                }
            } else {
                // Si no se encontró la factura, cliente, vendedor u orden por su ID, retornar un JSON con un mensaje de error
                echo json_encode(['error' => 'El ID de factura proporcionado NO es correcto.']);
            }
        } catch (\Throwable $th) {
            echo json_encode(['error' => $th->getMessage()]);
        }
    }


    public static function eliminarFacturaPorId($id)
    {
        // Creamos un objeto FacturaModel para la factura a eliminar
        $factura = FacturaModel::find($id);

        try {
            // Verificamos si se encontró la factura por su ID
            if ($factura) {
                // Intentamos eliminar la factura
                $resultado = $factura->eliminar();

                // Verificamos si la operación de eliminación fue exitosa
                if ($resultado) {
                    // Si la eliminación fue exitosa, retornar un JSON con un mensaje de éxito
                    echo json_encode(['mensaje' => 'Factura eliminada correctamente']);
                } else {
                    // Si ocurrió un error al eliminar la factura, retornar un JSON con un mensaje de error específico
                    echo json_encode(['error' => 'Error al eliminar la factura']);
                }
            } else {
                // Si no se encontró la factura por su ID, retornar un JSON con un mensaje de error
                echo json_encode(['error' => 'No se encontro la factura con el ID proporcionado']);
            }
        } catch (\Throwable $th) {
            echo json_encode(['error' => $th->getMessage()]);
        }
    }

    // -----------------------------------------------------------


    // --------------------------- OTRAS CONSULTAS -----------------------------
    public static function obtenerClienteVendedorOrdenPorIdFactura($id)
    {
        $consulta = ActiveRecord::obtenerClienteVendedorOrdenPorIdFactura($id);

        try {
            // Verificamos si se encontró la orden mediante la consulta
            if ($consulta) {
                echo json_encode($consulta);
            } else {
                // Si no se encontró la orden, retornar un JSON con el mensaje 'No se encontró por ID'
                echo json_encode(['mensaje' => 'No se encontro por ID']);
            }
        } catch (\Throwable $th) {
            echo json_encode(['error' => $th->getMessage()]);
        }
    }

    public static function obtenerFacturasPorOrdenPorIdOrden($id)
    {
        $consulta = ActiveRecord::obtenerFacturasPorOrdenPorIdOrden($id);

        try {
            // Verificamos si se encontró la orden mediante la consulta
            if ($consulta) {
                echo json_encode($consulta);
            } else {
                // Si no se encontró la orden, retornar un JSON con el mensaje 'No se encontró por ID'
                echo json_encode(['mensaje' => 'No se encontro por ID']);
            }
        } catch (\Throwable $th) {
            echo json_encode(['error' => $th->getMessage()]);
        }
    }
}
