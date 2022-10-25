# kubernetes-resource-generator
[![Maintainability Rating](https://sonarcloud.io/api/project_badges/measure?project=angelcamposm_kubernetes-resource-generator&metric=sqale_rating)](https://sonarcloud.io/summary/new_code?id=angelcamposm_kubernetes-resource-generator)
[![Reliability Rating](https://sonarcloud.io/api/project_badges/measure?project=angelcamposm_kubernetes-resource-generator&metric=reliability_rating)](https://sonarcloud.io/summary/new_code?id=angelcamposm_kubernetes-resource-generator)
[![Security Rating](https://sonarcloud.io/api/project_badges/measure?project=angelcamposm_kubernetes-resource-generator&metric=security_rating)](https://sonarcloud.io/summary/new_code?id=angelcamposm_kubernetes-resource-generator)
[![Vulnerabilities](https://sonarcloud.io/api/project_badges/measure?project=angelcamposm_kubernetes-resource-generator&metric=vulnerabilities)](https://sonarcloud.io/summary/new_code?id=angelcamposm_kubernetes-resource-generator)
[![Coverage](https://sonarcloud.io/api/project_badges/measure?project=angelcamposm_kubernetes-resource-generator&metric=coverage)](https://sonarcloud.io/summary/new_code?id=angelcamposm_kubernetes-resource-generator)

a PHP package to generate yaml files of Kubernetes resources.

### Generate a Pod definition

```php
use Acamposm\K8sResourceGenerator\Reference\Annotations\PodAnnotations;
use Acamposm\K8sResourceGenerator\Reference\Labels\PodLabels;
use Acamposm\K8sResourceGenerator\Enums\ImagePullPolicy;
use Acamposm\K8sResourceGenerator\Enums\OperatingSystem;
use Acamposm\K8sResourceGenerator\Enums\RestartPolicy;
use Acamposm\K8sResourceGenerator\Resources\Container;
use Acamposm\K8sResourceGenerator\Resources\Pod;

// Set well known kubernetes annotations
$podAnnotations = array_merge(
    PodAnnotations::deletionCost(500),
    PodAnnotations::defaultContainer('my-app-container'),
);

// Set common used kubernetes labels
$podLabels = array_merge(
    PodLabels::component('database'),
    PodLabels::instance('my-awesome-application-xyz'),
    PodLabels::managedBy('Kustomize'),
    PodLabels::name('my-awesome-application'),
    PodLabels::partOf('my-awesome-application'),
    PodLabels::version('1.0.0'),
);

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
    ->addLabels($podLabels)
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
    controller.kubernetes.io/pod-deletion-cost: 500
    imageregistry: 'https://hub.docker.com/'
    kubectl.kubernetes.io/default-container: my-app-container
  labels:
    app.kubernetes.io/component: database
    app.kubernetes.io/instance: my-awesome-application-xyz
    app.kubernetes.io/managed-by: Kustomize
    app.kubernetes.io/name: my-awesome-application
    app.kubernetes.io/part-of: my-awesome-application
    app.kubernetes.io/version: 1.0.0
spec:
  os:
    name: linux
  containers:
    - env:
        - name: DEBUG
          value: '*'
      image: 'alpine:latest'
      imagePullPolicy: Always
      name: app-name
      ports:
        - containerPort: 4000
          name: http-alt
          protocol: TCP
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
  restartPolicy: Never
  serviceAccount: pod-service-account
```
