<?php

namespace First\PageBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

class ExportOrdersCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('export:orders')
            ->setDescription('Export orders data to file.xls');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $helper = $this->getHelper('question');
        $question = new Question('Please enter path and name a file export: ', '/home/vagrant');

        //Путь к файлу экспорта
        $path = $helper->ask($input, $output, $question);

        //Получаем контейнер
        $gk = $this->getContainer();
        $em = $this->getContainer()->get('doctrine')->getManager();

        //Получаем список посетителей чей заказ уже обработан
        $repository = $em->getRepository('FirstPageBundle:all_order');
        $query = $repository->createQueryBuilder('q')
            ->where('q.accept = true')
            ->groupBy('q.ownerOrder')
            ->addGroupBy('q.idOrder')
            ->orderBy('q.id', 'ASC')
            ->getQuery();
        $users = $query->getResult();
        $col_user = count($users);//количество посетителей выполнивших заказ

        // Экспорт данных в файл xls
        $phpExcelObject = $gk->get('phpexcel')->createPHPExcelObject();

        $phpExcelObject->getProperties()->setCreator("Admin")
            ->setLastModifiedBy("Admin")
            ->setTitle("Title")
            ->setSubject("Office 2005 XLSX Subject Document")
            ->setDescription("Export orders")
            ->setKeywords("office 2005 openxml php")
            ->setCategory("Export menu file");

        for($i = 0; $i < $col_user; $i++) {
            //Инициализируем переменную с общей суммой заказа
            $allcost = 0.00;
            //Получаем имя пользователя
            $user_name = $users[$i]->getOwnerOrder();
            $idorder = $users[$i]->getIdOrder();

            //Формируем список заказаных посетителем блюд
            $query = $repository->createQueryBuilder('q')
                ->where('q.ownerOrder = \'' . $user_name . '\'')
                ->andWhere('q.accept = true')
                ->andWhere('q.idOrder = ' . $idorder)
                ->orderBy('q.id', 'ASC')
                ->getQuery();
            $order_menu = $query->getResult();
            $col_item = count($order_menu);//количество блюд в заказе

            $phpExcelObject->createSheet($i);
            $phpExcelObject->setActiveSheetIndex($i)
                ->setCellValue('B1', "Название")
                ->setCellValue('C1', "Количество гр.")
                ->setCellValue('D1', "Цена грн.");

            //Получаем все позиции в текущем заказе
            //и экспортируем в xls
            for($k = 0; $k < $col_item; $k++){
                $cell = $k+2;
                $allcost += (float)$order_menu[$k]->getCost();
                $phpExcelObject->setActiveSheetIndex($i)
                    ->setCellValue('B'. $cell, $order_menu[$k]->getNameDishes())
                    ->setCellValue('C'. $cell, $order_menu[$k]->getPortion())
                    ->setCellValue('D'. $cell, (float)$order_menu[$k]->getCost());
            }
            $cell = $col_item+2;
            $phpExcelObject->setActiveSheetIndex($i)
                ->setCellValue('D'. $cell, 'Всего к оплате: ' .$allcost. 'грн.');

            $phpExcelObject->getActiveSheet()->setTitle($user_name . ' Order ' .$idorder );
        }
        // Устанавливаем индекс активной страницы
        $phpExcelObject->setActiveSheetIndex(0);

        // Создаём редактор
        $writer = $gk->get('phpexcel')->createWriter($phpExcelObject, 'Excel5');

        // Сохраняем файл
        $writer->save($path);
        $output->writeln($path);
    }
}
