# kubernetes-resource-generator
[![Maintainability Rating](https://sonarcloud.io/api/project_badges/measure?project=angelcamposm_kubernetes-resource-generator&metric=sqale_rating)](https://sonarcloud.io/summary/new_code?id=angelcamposm_kubernetes-resource-generator)
[![Reliability Rating](https://sonarcloud.io/api/project_badges/measure?project=angelcamposm_kubernetes-resource-generator&metric=reliability_rating)](https://sonarcloud.io/summary/new_code?id=angelcamposm_kubernetes-resource-generator)
[![Security Rating](https://sonarcloud.io/api/project_badges/measure?project=angelcamposm_kubernetes-resource-generator&metric=security_rating)](https://sonarcloud.io/summary/new_code?id=angelcamposm_kubernetes-resource-generator)
[![Vulnerabilities](https://sonarcloud.io/api/project_badges/measure?project=angelcamposm_kubernetes-resource-generator&metric=vulnerabilities)](https://sonarcloud.io/summary/new_code?id=angelcamposm_kubernetes-resource-generator)
[![Coverage](https://sonarcloud.io/api/project_badges/measure?project=angelcamposm_kubernetes-resource-generator&metric=coverage)](https://sonarcloud.io/summary/new_code?id=angelcamposm_kubernetes-resource-generator)

a PHP package to generate yaml files of Kubernetes resources.

### Generate a Pod definition

```php
use Acamposm\KubernetesResourceGenerator\Enums\ImagePullPolicy;
use Acamposm\KubernetesResourceGenerator\Enums\OperatingSystem;
use Acamposm\KubernetesResourceGenerator\Enums\RestartPolicy;
use Acamposm\KubernetesResourceGenerator\Helpers\KubernetesRecommendedLabels;
use Acamposm\KubernetesResourceGenerator\Resources\Container;
use Acamposm\KubernetesResourceGenerator\Resources\Pod;

// Set common used kubernetes labels
$labels = new KubernetesRecommendedLabels();
$labels->name('my-awesome-application')
    ->instance('my-awesome-application-xyz')
    ->version('1.0.0')
    ->managedBy('Kustomize')
    ->partOf('my-awesome-application');

// Now set a container for the pod
$container = new Container();
$container->name('app-name')
    ->addEnvVariable('DEBUG', '*')
    ->addPorts([
        [
            'containerPort' => 4000,
            'name' => 'http-alt',
            'protocol' => 'TCP'
        ]
    ])
    ->image('alpine:latest')
    ->imagePullPolicy(ImagePullPolicy::ALWAYS)
    ->setCpuRequest('100m')
    ->setCpuLimit(1)
    ->setMemoryLimit('120Mi')
    ->setMemoryRequest('1Gi');

// Finally fill the Pod values 
$pod = new Pod();
$pod->name('pod-name')
    ->namespace('my-awesome-project')
    ->addAnnotation('imageregistry', 'https://hub.docker.com/')
    ->addLabels($labels->toArray())
    ->addContainers([$container->toArray()])
    ->addImagePullSecret('registry-access-secret')
    ->addNodeSelectors([
        'type' => 'compute',
        'diskType' => 'ssd'
    ])
    ->osName(OperatingSystem::LINUX)
    ->restartPolicy(RestartPolicy::NEVER)
    ->serviceAccount('pod-service-account')
    ->toYaml();
```

Use toYaml() method to generate a YAML representation of the Kubernetes resource.

```yaml
apiVersion: v1
kind: Pod
metadata:
  name: pod-name
  namespace: my-awesome-project
  annotations:
    imageregistry: 'https://hub.docker.com/'
  labels:
    app.kubernetes.io/name: my-awesome-application
    app.kubernetes.io/instance: my-awesome-application-xyz
    app.kubernetes.io/version: 1.0.0
    app.kubernetes.io/managed-by: Kustomize
    app.kubernetes.io/part-of: my-awesome-application
spec:
  containers:
    - name: app-name
      image: 'alpine:latest'
      environment:
        - name: DEBUG
          value: '*'
      ports:
        - containerPort: 4000
          name: http-alt
          protocol: TCP
      imagePullPolicy: Always
      resources:
        limits:
          cpu: '1'
          memory: '120Mi'
        requests:
          cpu: '100m'
          memory: '1Gi'
  imagePullSecrets:
    - name: registry-access-secret
  nodeSelector:
    type: compute
    diskType: ssd
  os:
    name: linux
  restartPolicy: Never
  serviceAccount: pod-service-account
```
