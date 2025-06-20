<?php

$pageTitle = "Gestion des messages";
$pageDescription = "Gérer les messages de l'application";

require_once "queries/messages.php";
$messages = getMessages();


require_once __DIR__ . '/partials/header.php';
?>

<div class="container mx-auto px-4 py-8">

    <?php if ($messages): ?>
        <div class="w-full overflow-hidden rounded-lg shadow-xs mt-8">
            <div class="w-full overflow-x-auto">
                <table class="w-full whitespace-no-wrap">
                    <thead>
                        <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Utilisateur</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Message</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                        <?php foreach ($messages as $message): ?>
                            <tr class="text-gray-700 dark:text-gray-400">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"><?php echo htmlspecialchars($message['id']); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                  <div class="flex items-center text-sm">
                                        <!-- Avatar with inset shadow -->
                                        <div
                                            class="relative hidden w-8 h-8 mr-3 rounded-full md:block  ">
                                            <img
                                                class="object-cover w-full h-full rounded-full"
                                                src="https://avataaars.io/?avatarStyle=Transparent&topType=LongHairFro&accessoriesType=Blank&hairColor=Brown&facialHairType=Blank&clotheType=ShirtCrewNeck&clotheColor=Pink&eyeType=Default&eyebrowType=Default&mouthType=Default&skinColor=Brown"
                                                alt=""
                                                loading="lazy" />
                                            <div
                                                class="absolute inset-0 rounded-full shadow-inner"
                                                aria-hidden="true"></div>
                                        </div>
                                        <div>
                                            <p class="font-semibold"> <?php echo htmlspecialchars($message['author']); ?> </p>
                                            <p class="text-xs text-gray-600 dark:text-gray-400">
                                                <?php echo htmlspecialchars($message['email']); ?> </p>
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo htmlspecialchars($message['contenu']); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo htmlspecialchars($message['date']); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="/admin/messages_action.php?action=view&id=<?php echo $message['id']; ?>" class="text-indigo-600 hover:text-indigo-900">Voir</a>
                                    <a href="/admin/messages_action.php?action=reply&id=<?php echo $message['id']; ?>" class="text-green-600 hover:text-green-900 ml-4">Répondre</a>
                                </td>
                            </tr>

                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="text-gray-600">Aucun message trouvé.</p>
        <?php endif; ?>
        </div>
</div>