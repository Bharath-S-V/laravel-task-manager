<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Coalition Technologies</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Import Three.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>

    <!-- Bootstrap CSS for Layout -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            margin: 0;
            font-family: 'Arial', sans-serif;
            height: 100vh;
            background-color: #f7f7f7;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
        }

        #scene-container {
            width: 100%;
            height: 100%;
            position: absolute;
            top: 0;
            left: 0;
        }

        .content {
            z-index: 1;
            text-align: center;
            color: #333;
            max-width: 80%;
            margin: 0 auto;
        }

        h1 {
            font-size: 3rem;
            font-weight: 700;
            color: #007bff;
        }

        p {
            font-size: 1.2rem;
            color: #555;
        }

        .btn-welcome {
            background-color: #007bff;
            color: white;
            padding: 15px 40px;
            font-size: 20px;
            font-weight: 600;
            border: none;
            border-radius: 50px;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .btn-welcome:hover {
            background-color: #0056b3;
            transform: translateY(-5px);
        }

        .btn-welcome:focus {
            box-shadow: 0 0 10px rgba(0, 123, 255, 0.7);
        }

        .card {
            border: none;
            box-shadow: 0px 15px 30px rgba(0, 123, 255, 0.1);
            background: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            padding: 20px;
            margin-top: 20px;
        }

        .card-header {
            background: #007bff;
            color: white;
            border-radius: 15px;
            padding: 10px;
        }

        .card-body {
            text-align: left;
            padding: 15px;
        }

        .card-body ul {
            list-style-type: none;
            padding-left: 0;
        }

        .card-body li {
            background: #f1f1f1;
            margin: 10px 0;
            padding: 10px;
            border-radius: 10px;
            transition: background 0.3s ease;
        }

        .card-body li:hover {
            background: #e1e1e1;
        }
    </style>
</head>

<body>
    <div id="scene-container"></div>

    <div class="content">
        <h1>Welcome</h1>
        <p>Innovative solutions for your business growth</p>
        <a href="{{ route('tasks.index') }}" class="btn-welcome">Go to Task Manager</a>

        <div class="card mt-5">
            <div class="card-header">
                <h5>About Us</h5>
            </div>
            <div class="card-body">
                <ul>
                    <li>We specialize in tech solutions for modern businesses.</li>
                    <li>Offering web and app development services tailored to your needs.</li>
                    <li>Innovating through technology to help you stay ahead of the curve.</li>
                </ul>
            </div>
        </div>
    </div>

    <script>
        // Setup for Three.js 3D Animation
        let scene, camera, renderer, cube;

        function init() {
            scene = new THREE.Scene();
            camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);
            renderer = new THREE.WebGLRenderer();
            renderer.setSize(window.innerWidth, window.innerHeight);
            renderer.setClearColor(0xf7f7f7); // Set background to light color
            document.getElementById('scene-container').appendChild(renderer.domElement);

            // Create a rotating cube with soft light
            const geometry = new THREE.BoxGeometry();
            const material = new THREE.MeshStandardMaterial({
                color: 0x007bff
            });
            cube = new THREE.Mesh(geometry, material);
            scene.add(cube);

            // Add ambient light to the scene
            const light = new THREE.AmbientLight(0xffffff, 1);
            scene.add(light);

            camera.position.z = 5;

            // Animation loop
            function animate() {
                requestAnimationFrame(animate);

                // Rotate the cube for a dynamic effect
                cube.rotation.x += 0.01;
                cube.rotation.y += 0.01;

                renderer.render(scene, camera);
            }

            animate();
        }

        // Initialize the 3D scene
        init();

        // Handle resizing of the window
        window.addEventListener('resize', function() {
            renderer.setSize(window.innerWidth, window.innerHeight);
            camera.aspect = window.innerWidth / window.innerHeight;
            camera.updateProjectionMatrix();
        });
    </script>

</body>

</html>
